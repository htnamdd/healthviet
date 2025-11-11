<?php
namespace Healthviet\Banner\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.1.0', '<')) {
            $this->addMobileImageColumn($setup);
        }

        $setup->endSetup();
    }

    private function addMobileImageColumn(SchemaSetupInterface $setup)
    {
        $tableName = $setup->getTable('healthviet_banner_banner');

        $setup->getConnection()->addColumn(
            $tableName,
            'mobile_image',
            [
                'type' => Table::TYPE_TEXT,
                'nullable' => true,
                'comment' => 'Mobile Image'
            ]
        );
    }
}
