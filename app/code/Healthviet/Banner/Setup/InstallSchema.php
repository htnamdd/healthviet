<?php


namespace Healthviet\Banner\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $table_healthviet_banner_banner = $setup->getConnection()->newTable($setup->getTable('healthviet_banner_banner'));

        $table_healthviet_banner_banner->addColumn(
            'banner_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true,'nullable' => false,'primary' => true,'unsigned' => true,],
            'Entity ID'
        );

        $table_healthviet_banner_banner->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'title'
        );

        $table_healthviet_banner_banner->addColumn(
            'subtitle',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'subtitle'
        );

        $table_healthviet_banner_banner->addColumn(
            'enable',
            \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
            null,
            [],
            'enable'
        );

        $table_healthviet_banner_banner->addColumn(
            'url_redirect',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'url_redirect'
        );

        $table_healthviet_banner_banner->addColumn(
            'show_title',
            \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
            null,
            [],
            'show_title'
        );

        $table_healthviet_banner_banner->addColumn(
            'target',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'target'
        );

        $table_healthviet_banner_banner->addColumn(
            'image',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'image'
        );

        $table_healthviet_banner_banner->addColumn(
            'sort_order',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [],
            'sort_order'
        );

        $table_healthviet_banner_banner->addColumn(
            'slider_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [],
            'slider_id'
        );

        $table_healthviet_banner_slider = $setup->getConnection()->newTable($setup->getTable('healthviet_banner_slider'));

        $table_healthviet_banner_slider->addColumn(
            'slider_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true,'nullable' => false,'primary' => true,'unsigned' => true,],
            'Entity ID'
        );

        $table_healthviet_banner_slider->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'title'
        );

        $table_healthviet_banner_slider->addColumn(
            'show_title',
            \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
            null,
            [],
            'show_title'
        );

        $table_healthviet_banner_slider->addColumn(
            'enable',
            \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
            null,
            [],
            'enable'
        );

        $table_healthviet_banner_slider->addColumn(
            'slider_code',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'slider_code'
        );

        $table_healthviet_banner_slider->addColumn(
            'icon',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'icon'
        );

        $setup->getConnection()->createTable($table_healthviet_banner_slider);

        $setup->getConnection()->createTable($table_healthviet_banner_banner);
    }
}
