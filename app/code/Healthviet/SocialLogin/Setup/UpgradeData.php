<?php
namespace Healthviet\SocialLogin\Setup;

use Magento\Customer\Model\Customer;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{
    private $_eavSetupFactory;

    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->_eavSetupFactory = $eavSetupFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->_eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
            Customer::ENTITY,
            'healthviet_sociallogin_id',
            array(
                'type' => 'text',
                'visible' => false,
                'required' => false,
                'user_defined' => false,
                'label' => 'Healthviet Social Id',
                'system' => false
            )
        );
        $eavSetup->addAttribute(
            Customer::ENTITY,
            'healthviet_sociallogin_type',
            array(
                'type' => 'text',
                'visible' => false,
                'required' => false,
                'user_defined' => false,
                'label' => 'Healthviet Social Type',
                'system' => false
            )
        );
    }
}
