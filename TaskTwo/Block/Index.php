<?php


namespace Amasty\TaskTwo\Block;


use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Amasty\TaskTwo\Api\Data\NameProviderInterface;


class Index extends Template
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var EventManager
     */
    private $eventManager;

    /**
     * @var NameProviderInterface
     */
    private $nameProvider;

    public function __construct(
        NameProviderInterface $nameProvider,
        EventManager          $eventManager,
        Template\Context      $context, array $data = [],
        ScopeConfigInterface  $scopeConfig
    )
    {
        $this->nameProvider = $nameProvider;
        $this->eventManager = $eventManager;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    public function getValueQtyAndHello($path)
    {
        return $this->scopeConfig->getValue($path);
    }

    public function showQty()
    {
        return $this->scopeConfig->isSetFlag('Quantity_config/hello_message/enabled_quantity');
    }

    public function formAction()
    {
        return $this->getUrl('*/index/addcart');
    }

    public function helloWorld($name)
    {
        $this->eventManager->dispatch(
             'asmasty_tasktwo_check_name',
             ['name_to_check' => $name]
         );

        return 'hey ' . $name;
    }

}
