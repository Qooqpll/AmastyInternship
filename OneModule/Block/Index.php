<?php


namespace Amasty\OneModule\Block;


use Magento\Framework\View\Element\Template;

class Index extends Template
{
    public function __construct(\Magento\Framework\View\Element\Template\Context $context)
    {
        parent::__construct($context);
    }

    public function sayHello()
    {
        return __('Hello World');
    }

}
