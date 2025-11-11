<?php
declare(strict_types=1);

namespace Healthviet\Directory\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use Healthviet\Directory\Model\Import\ReadCsvFileProvider;

class InsertWardsDataVn implements DataPatchInterface, PatchVersionInterface
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
    protected array $districts = [];

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

        $this->initDistrictsData($connection);
        $source = $this->readCsvFileProvider->getSource('1d-shipping-metadata-wards');

        $source->rewind();

        $districtsData = [];

        while ($source->valid()) {
            $rowData = $source->current();
            $districtId = $rowData['district_id'];

            if (!isset($this->districts[$districtId])) {
                continue;
            }

            $districtId = $this->districts[$districtId]['district_id'];

            array_push($districtsData, [
                'district_id' => $districtId,
                'default_name' => $rowData['name'],
                '1d_id' => $rowData['id'],
            ]);

            $source->next();
        }

        $tableName = $connection->getTableName('directory_district_ward');
        $connection->insertMultiple($tableName, $districtsData);

        $connection->endSetup();
    }

    /**
     * @param AdapterInterface $connection
     */
    protected function initDistrictsData(AdapterInterface $connection)
    {
        $regionTableName = $connection->getTableName('directory_region_district');
        $select = $connection->select()->from($regionTableName, ['1d_id', 'district_id']);

        $this->districts = $connection->fetchAssoc($select);
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies(): array
    {
        return [InsertDistrictsDataVn::class];
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
