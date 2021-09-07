<?php


namespace Amasty\TaskTwo\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class ConfigProvider extends ConfigProviderAbstract
{
    protected $pathPrefix = 'Quantity_config';
    /**
     * @var ScopeConfigInterface
     */
    public $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($scopeConfig);
    }

    public function getInEnabled($storeId = null)
    {
        $this->scopeConfig->isSetFlag($this->pathPrefix . 'Quantity_config/hello_message/enabled_quantity', $storeId);
    }

    public function getIsShowQtyField($storeId = null)
    {
        $this->scopeConfig( $this->pathPrefix . 'Quantity_config/hello_message/quantity_input',$storeId);
    }

}
