<?php
declare(strict_types=1);

namespace Healthviet\Directory\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use Healthviet\Directory\Model\Import\ReadCsvFileProvider;

class InsertRegionDataVn implements DataPatchInterface, PatchVersionInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    protected ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @var ReadCsvFileProvider
     */
    protected ReadCsvFileProvider $readCsvFileProvider;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param ReadCsvFileProvider $readCsvFileProvider
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        ReadCsvFileProvider $readCsvFileProvider
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->readCsvFileProvider = $readCsvFileProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $connection = $this->moduleDataSetup->getConnection();

        $source = $this->readCsvFileProvider->getSource('1d-shipping-metadata-provinces');

        $source->rewind();

        $regionsData = [];

        while ($source->valid()) {
            $rowData = $source->current();
            $id = $rowData['id'];

            array_push($regionsData, [
                'country_id' => 'VN',
                'code' => $id,
                '1d_id' => $id,
                'default_name' => $rowData['name']
            ]);

            $source->next();
        }

        $tableName = $connection->getTableName('directory_country_region');
        $connection->insertMultiple($tableName, $regionsData);

        $connection->endSetup();
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
    public static function getVersion(): string
    {
        return '1.0.0';
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases(): array
    {
        return [];
    }
}
