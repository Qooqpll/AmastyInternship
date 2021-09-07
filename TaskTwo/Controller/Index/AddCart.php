<?php


namespace Amasty\TaskTwo\Controller\Index;


use Amasty\TaskTwo\Model\BlacklistFactory;
use Amasty\TaskTwo\Model\ResourceModel\Blacklist;
use Amasty\TaskTwo\Model\ResourceModel\Blacklist\CollectionFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Checkout\Model\Cart;


class AddCart extends Action
{

    /**
     * @var Cart
     */
    private $cart;

    /**
     * @var Blacklist
     */
    private $blacklistResource;

    /**
     * @var BlacklistFactory
     */
    private $blacklistFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var CheckoutSession
     */
    private $session;

    /**
     * @var scopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var ProductCollectionFactory
     */
    private $productCollection;

    public function __construct(
        Cart                       $cart,
        Blacklist                  $blacklistResource,
        BlacklistFactory           $blacklistFactory,
        CollectionFactory          $collectionFactory,
        Context                    $context,
        ScopeConfigInterface       $scopeConfig,
        CheckoutSession            $session,
        ProductRepositoryInterface $productRepository,
        ProductCollectionFactory   $productCollection
    )
    {
        $this->cart = $cart;
        $this->blacklistFactory = $blacklistFactory;
        $this->blacklistResource = $blacklistResource;
        $this->collectionFactory = $collectionFactory;
        $this->scopeConfig = $scopeConfig;
        $this->session = $session;
        $this->productRepository = $productRepository;
        $this->productCollection = $productCollection;
        parent::__construct($context);
    }

    public function redirectToIndex()
    {
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl('http://magento.loc/username/index/index');
        return $redirect;
    }

    public function checkSkuToBlacklist($sku, $qty)
    {
        /**
         * @var \Amasty\TaskTwo\Model\ResourceModel\Blacklist\Collection $collection
         */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(
            'sku',
            ['eq' => $sku]
        );

        /**
         * @var \Amasty\TaskTwo\Model\Blacklist $item
         */
        if ($collection->getData()) {
            foreach ($collection as $item) {
                return $this->calculateQty($this->getQtyCart($sku), $item->getQty(), $qty);
            }
        } else {
            $this->addToBlacklist($sku);
        }
    }

    public function addToBlacklist($sku)
    {
        $blacklist = $this->blacklistFactory->create();
        $blacklist->setSku($sku);
        $blacklist->setQty(100);
        $this->blacklistResource->save($blacklist);
    }

    public function calculateQty($cartQty, $dbQty, $qty)
    {
        try {
            $addQty = $cartQty + $qty;
            if ($dbQty >= $addQty) {
                return $addQty;
            } else {
                return $dbQty;
                throw new NoSuchEntityException(__('add cart' . $dbQty));
            }
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addExceptionMessage($e);
        }
    }

    public function getQtyCart($sku)
    {
        $cart = $this->session->getQuote()->getAllItems();
        foreach ($cart as $item) {
            if ($sku == $item->getSku()) {
                return $item->getQty();
            }
        }
    }

    public function execute()
    {
        $params = $this->getRequest()->getParams();
        $qty = $this->checkSkuToBlacklist($params['sku'], $params['qty']);


        $quote = $this->session->getQuote();
        if (!$quote->getId()) {
            $quote->save();
        }

        try {

            $product = $this->productRepository->get($params['sku']);
            $productQty = $product->getExtensionAttributes()->getStockItem()->getQty();
            try {
                if ($product->getTypeId() == 'simple') {
                    if ($productQty > $params['qty']) {
                        $quote->addProduct($product, $qty);
                        $quote->save();

                    } else {
                        throw new NoSuchEntityException(__('insufficient quantity of goods'));
                    }
                } else {
                    throw new NoSuchEntityException(__('it is product not simple'));
                }

            } catch (NoSuchEntityException $e) {
                $this->messageManager->addExceptionMessage($e);
                return $this->redirectToIndex();
            }
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addExceptionMessage($e);
            return $this->redirectToIndex();
        } finally {
            $this->messageManager->addComplexSuccessMessage('product add to cart');
            return $this->redirectToIndex();
        }

    }
}
