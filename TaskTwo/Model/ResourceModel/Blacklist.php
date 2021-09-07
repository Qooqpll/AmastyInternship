<?php

namespace Amasty\TaskTwo\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Blacklist extends AbstractDb
{

    public function _construct()
    {
        $this->_init(
            \Amasty\TaskTwo\Setup\InstallSchema::TABLE_NAME,
            'backlist_id'
        );
    }

}
