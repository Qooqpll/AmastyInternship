<?php

namespace Amasty\MageMastery\Plugin;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\UrlInterface;



class FormActionPlugin
{
    /**
     * @var ResultFactory
     */
    private $resultFactory;

    /**
     * @var UrlInterface
     */
    private $url;

    public function __construct(
        UrlInterface $url,
        ResultFactory $resultFactory
    )
    {
        $this->url = $url;
        $this->resultFactory = $resultFactory;
    }

    public function afterFormAction(
        $subject
    )
    {
        return $this->url->getUrl("checkout/cart/add");

    }

}
