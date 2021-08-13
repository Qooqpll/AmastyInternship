<?php


namespace Amasty\TaskTwo\Block;


use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Index extends Template
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        Template\Context $context, array $data = [],
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    public function getValueQtyAndHello($path) {
        return $this->scopeConfig->getValue($path);
    }

    public function showQty()
    {
        return $this->scopeConfig->isSetFlag('Quantity_config/hello_message/enabled_quantity');
    }

   /* public function getValueQty()
    {
        return $this->scopeConfig->getValue('Quantity_config/hello_message/quantity_input');
    }*/
}
