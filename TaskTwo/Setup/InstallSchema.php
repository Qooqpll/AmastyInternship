<?php

namespace Amasty\TaskTwo\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{

    const TABLE_NAME = 'Blacklist';

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $table = $setup->getConnection()
            ->newTable($setup->getTable(self::TABLE_NAME))
            ->addColumn(
                'backlist_id',
                Table::TYPE_INTEGER,  // тип колонки
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Blacklist ID'
            )
            ->addColumn(
                'sku',
                Table::TYPE_TEXT,
                30,
                [
                    'nullable' => false,
                    'default' => '',
                ],
                'Product sku'
            )
            ->addColumn(
                'qty',
                Table::TYPE_INTEGER,
                30,
                [
                    'identity' => false,
                    'unsigned' => false,
                    'nullable' => false,
                    'primary' => false
                ],
                'Product qty'
            )
            ->setComment('Blacklist table');
        $setup->getConnection()->createTable($table);
        $setup->endSetup();

    }

}
