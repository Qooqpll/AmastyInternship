<?php


namespace Amasty\TaskTwo\Controller\Index;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;


class AddCart extends Action
{

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
        Context $context,
        ScopeConfigInterface $scopeConfig,
        CheckoutSession $session,
        ProductRepositoryInterface $productRepository,
        ProductCollectionFactory $productCollection
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->session = $session;
        $this->productRepository = $productRepository;
        $this->productCollection = $productCollection;
        parent::__construct($context);
    }

    public function redirectToIndex()
    {
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl('http://yourname.magento.com/username/index/index');
        return $redirect;
    }

    public function execute()
    {
        $quote = $this->session->getQuote();
        if (!$quote->getId()) {
            $quote->save();
        }

        try {
            $product = $this->productRepository->get($_GET['sku']);
            $productQty = $product->getExtensionAttributes()->getStockItem()->getQty();
            try {
                if ($product->getTypeId() == 'simple') {
                    if ($productQty > $_GET['qty']) {
                        $quote->addProduct($product, $_GET['qty']);
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
