<?php


namespace Amasty\OneModule\Controller\Index;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;

class Index extends Action implements HttpGetActionInterface
{
    public function execute() {
        echo 'Спустя 5 дней я устаовил magento... Ура! Ура! Ура!';
    }
}
