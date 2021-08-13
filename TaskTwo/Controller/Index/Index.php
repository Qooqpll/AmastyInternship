<?php


namespace Amasty\TaskTwo\Controller\Index;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Checkout\Model\Session;


class Index extends Action
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        scopeConfigInterface $scopeConfig,
        Context $context
    )
    {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    public function execute()
    {
        if($this->scopeConfig->isSetFlag('Quantity_config/hello_message/enabled_module')){
            return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        } else {
            die('Модуль выключен');
        }

    }
}
