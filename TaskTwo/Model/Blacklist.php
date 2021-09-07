<?php

namespace Amasty\TaskTwo\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class wish
 * @method string getText()
 * @method bool getDone()
 */
class Blacklist extends AbstractModel
{

    protected function _construct()
    {
        $this->_init(
            ResourceModel\Blacklist::class
        );
    }

}
