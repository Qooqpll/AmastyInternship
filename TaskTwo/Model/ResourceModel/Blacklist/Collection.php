<?php

namespace Amasty\TaskTwo\Model\ResourceModel\Blacklist;

use Amasty\TaskTwo\Model\Blacklist;
use Amasty\TaskTwo\Model\ResourceModel\Blacklist as BlacklistResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected function _construct()
    {
        $this->_init(
            Blacklist::class,
            BlacklistResource::class
        );
    }

}
