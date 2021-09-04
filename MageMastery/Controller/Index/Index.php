<?php


namespace Amasty\MageMastery\Controller\Index;



use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as productCollectionFactory;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Amasty\TaskTwo\Controller\Index\Index as TaskTwo;
use Magento\Framework\App\Config\ScopeConfigInterface;


class Index extends TaskTwo
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Context $context,
        CheckoutSession $session,
        ProductRepositoryInterface $productRepository,
        ProductCollectionFactory $productCollectionFactory
    )
    {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($scopeConfig, $context, $session, $productRepository, $productCollectionFactory);
    }

    public function execute()
    {
        $customerSession = $this->_objectManager->get('Magento\Customer\Model\Session');
        if($customerSession->isLoggedIn()) {
            if($this->scopeConfig->isSetFlag('Quantity_config/hello_message/enabled_module')){
                return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
            } else {
                die('Модуль выключен');
            }
        } else {
            die('не залогинен');
        }

    }
}
