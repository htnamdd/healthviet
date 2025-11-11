<?php

namespace Healthviet\Shipping\Setup\Patch\Data;

use Magento\Customer\Api\AddressMetadataManagementInterface;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class DirectoryCustomerAddressAttributes implements DataPatchInterface
{
    /**
     * @var Config
     */
    protected $eavConfig;

    /**
     * @var EavSetupFactory
     */
    protected $eavSetupFactory;

    /**
     * @param Config $eavConfig
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        Config $eavConfig,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->eavConfig = $eavConfig;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function apply(): void
    {
        /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create();
        $eavSetup->removeAttribute('customer_address', 'district_id');
        $eavSetup->removeAttribute('customer_address', 'district');
        $eavSetup->removeAttribute('customer_address', 'ward_id');
        $eavSetup->removeAttribute('customer_address', 'ward');

        $eavSetup->addAttribute(
            AddressMetadataManagementInterface::ENTITY_TYPE_ADDRESS,
            'district_id',
            [
            'type' => 'static',
            'input' => 'text',
            'label' => 'District ID',
            'required' => false,
            'visible' => true,
            'system' => false,
            'is_used_in_grid' => false,
            'is_visible_in_grid' => false,
            'is_filterable_in_grid' => false,
            'is_searchable_in_grid' => false,
            'backend' => ''
        ]
        );

        $eavSetup->addAttribute(
            AddressMetadataManagementInterface::ENTITY_TYPE_ADDRESS,
            'district',
            [
            'type' => 'static',
            'input' => 'text',
            'label' => 'District',
            'required' => false,
            'source' => '',
            'visible' => true,
            'system' => false,
            'is_used_in_grid' => false,
            'is_visible_in_grid' => false,
            'is_filterable_in_grid' => false,
            'is_searchable_in_grid' => false,
            'backend' => '',
            'sort_order' => 220,
            'position' => 220
        ]
        );

        $eavSetup->addAttribute(
            AddressMetadataManagementInterface::ENTITY_TYPE_ADDRESS,
            'ward_id',
            [
            'type' => 'static',
            'input' => 'text',
            'label' => 'Ward ID',
            'required' => false,
            'visible' => true,
            'system' => false,
            'is_used_in_grid' => false,
            'is_visible_in_grid' => false,
            'is_filterable_in_grid' => false,
            'is_searchable_in_grid' => false,
            'backend' => ''
        ]
        );

        $eavSetup->addAttribute(
            AddressMetadataManagementInterface::ENTITY_TYPE_ADDRESS,
            'ward',
            [
            'type' => 'static',
            'input' => 'text',
            'label' => 'Ward',
            'required' => false,
            'source' => '',
            'visible' => true,
            'system' => false,
            'is_used_in_grid' => false,
            'is_visible_in_grid' => false,
            'is_filterable_in_grid' => false,
            'is_searchable_in_grid' => false,
            'backend' => '',
            'sort_order' => 200,
            'position' => 200
        ]
        );

        $districtIdAttribute = $this->eavConfig->getAttribute(
            AddressMetadataManagementInterface::ENTITY_TYPE_ADDRESS,
            'district_id'
        );
        $districtIdAttribute->setData(
            'used_in_forms',
            [
                'adminhtml_customer_address',
                'customer_address_edit',
                'customer_register_address'
            ]
        );
        $districtIdAttribute->save();

        $districtAttribute = $this->eavConfig->getAttribute(
            AddressMetadataManagementInterface::ENTITY_TYPE_ADDRESS,
            'district'
        );
        $districtAttribute->setData(
            'used_in_forms',
            [
                'adminhtml_customer_address',
                'customer_address_edit',
                'customer_register_address'
            ]
        );
        $districtAttribute->save();

        $wardIdAttribute = $this->eavConfig->getAttribute(
            AddressMetadataManagementInterface::ENTITY_TYPE_ADDRESS,
            'ward_id'
        );
        $wardIdAttribute->setData(
            'used_in_forms',
            [
                'adminhtml_customer_address',
                'customer_address_edit',
                'customer_register_address'
            ]
        );
        $wardIdAttribute->save();

        $wardAttribute = $this->eavConfig->getAttribute(
            AddressMetadataManagementInterface::ENTITY_TYPE_ADDRESS,
            'ward'
        );
        $wardAttribute->setData(
            'used_in_forms',
            [
                'adminhtml_customer_address',
                'customer_address_edit',
                'customer_register_address'
            ]
        );
        $wardAttribute->save();
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases(): array
    {
        return [];
    }
}
