<?php


namespace Amasty\MageMastery\Block;


use Magento\Framework\View\Element\Template;

class Index extends Template
{
    public function say($name) {
        return 'hello' . $name;
    }
}
