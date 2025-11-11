<?php
namespace Healthviet\Checkout\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Cms\Model\BlockFactory;

class CreateQrCodeBlock implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var BlockFactory
     */
    private $blockFactory;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param BlockFactory $blockFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        BlockFactory $blockFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->blockFactory = $blockFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $block = $this->blockFactory->create();
        $block->setTitle('QR Code Block');
        $block->setIdentifier('healthviet_checkout_qr_code');
        $block->setContent(
            '<p>Bạn vui lòng chuyển khoản cho Sức Khỏe Việt theo mã QR dưới đây.</p>
            <div class="qr-code">
                <img src="{{view url=Healthviet_Checkout/images/qr-code.jpeg}}" alt="QR Code" />
            </div>'
        );
        $block->setStoreId(0);
        $block->save();

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function revert()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $block = $this->blockFactory->create()->load('healthviet_checkout_qr_code', 'identifier');
        if ($block->getId()) {
            $block->delete();
        }

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
