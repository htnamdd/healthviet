<?php
declare(strict_types=1);

namespace Healthviet\Directory\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use Healthviet\Directory\Model\Import\ReadCsvFileProvider;

class InsertDistrictsDataVn implements DataPatchInterface, PatchVersionInterface
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
     * @var array
     */
    protected array $regions = [];

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

        $this->initRegionsData($connection);
        $source = $this->readCsvFileProvider->getSource('1d-shipping-metadata-districts');

        $source->rewind();

        $districtsData = [];

        while ($source->valid()) {
            $rowData = $source->current();
            $provinceId = $rowData['province_id'];

            if (!isset($this->regions[$provinceId])) {
                continue;
            }

            $regionId = $this->regions[$provinceId]['region_id'];

            array_push($districtsData, [
                'region_id' => $regionId,
                'default_name' => $rowData['name'],
                '1d_id' => $rowData['id'],
            ]);

            $source->next();
        }

        $tableName = $connection->getTableName('directory_region_district');
        $connection->insertMultiple($tableName, $districtsData);

        $connection->endSetup();
    }

    /**
     * @param AdapterInterface $connection
     */
    protected function initRegionsData(AdapterInterface $connection)
    {
        $regionTableName = $connection->getTableName('directory_country_region');
        $select = $connection->select()->from($regionTableName, ['1d_id', 'region_id'])
                                        ->where('country_id = (?)', 'VN');

        $this->regions = $connection->fetchAssoc($select);
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies(): array
    {
        return [InsertRegionDataVn::class];
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
