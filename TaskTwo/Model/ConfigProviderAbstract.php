<?php


namespace Amasty\TaskTwo\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;


class ConfigProviderAbstract
{
    /**
     * @var scopeConfigInterface
     */
    protected $scopeConfig;

    private $pathPrifix = 'Quantity_config';

    public function __construct(
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function getValue($path = null, $scope = null, $storeId = null)
    {
        $this->scopeConfig->getValue(
            $this->pathPrifix . $path,
            $scope,
            $storeId
        );
    }

}
