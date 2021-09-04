<?php

namespace Amasty\MageMastery\Observer;


use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class CheckIsVasyaObserver implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        $name = $observer->getData('name_to_check');

        if(strtolower($name) == 'vasya') {
            die('go to home');
    }
    }
}
