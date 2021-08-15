<?php


namespace Amasty\TaskTwo\Controller\Index;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Catalog\Api\ProductRepositoryInterface;


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


    public function __construct(
        scopeConfigInterface $scopeConfig,
        Context $context,
        CheckoutSession $session,
        productRepositoryInterface $productRepository
    )
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    public function execute()
    {

        var_dump($this->session->getData());

     /*   if($this->scopeConfig->isSetFlag('Quantity_config/hello_message/enabled_module')){
            return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        } else {
            die('Модуль выключен');
        }*/

    }
}
