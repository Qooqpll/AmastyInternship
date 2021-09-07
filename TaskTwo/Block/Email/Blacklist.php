<?php

namespace Amasty\TaskTwo\Block\Email;

use Magento\Framework\View\Element\Template;

class Blacklist extends Template
{

    public function __construct(
        Template\Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
    }

    public function getSku()
    {
        return $this->getData('blacklist_sku');
    }

    public function getQty()
    {
        return $this->getData('blacklist_qty');
    }

}
