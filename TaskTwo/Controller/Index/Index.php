<?php


namespace Amasty\TaskTwo\Controller\Index;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;


class Index extends Action
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var CheckoutSession
     */
    private $session;
    /**
     * @var productRepositoryInterface
     */
    private $productRepository;

    /**
     * @var ProductCollectionFactory
     */
    private $productCollectionFactory;


    public function __construct(
        scopeConfigInterface $scopeConfig,
        Context $context,
        CheckoutSession $session,
        productRepositoryInterface $productRepository,
        productCollectionFactory $productCollectionFactory
    )
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
        $this->scopeConfig = $scopeConfig;
        $this->productCollectionFactory = $productCollectionFactory;

        parent::__construct($context);
    }

    public function execute()
    {
/*
        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addAttributeToFilter('sku', ['24-MB01']);
        $productCollection->addAttributeToFilter('type', ['24-MB01']);
        foreach($productCollection as $product) {
            echo $product->getSku();
        }
        die('done');*/

       /* $product = $this->productRepository->get('24-MB01');

        $quote = $this->session->getQuote();
        if(!$quote->getId()) {
            $quote->save();
        }

        $quote->addProduct($product, 2);
        $quote->save();
        die('done');*/

        if($this->scopeConfig->isSetFlag('Quantity_config/hello_message/enabled_module')){
            return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        } else {
            die('Модуль выключен');
        }

    }
}
