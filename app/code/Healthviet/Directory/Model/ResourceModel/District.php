<?php
declare(strict_types=1);

namespace Healthviet\Directory\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class District extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'directory_region_district_resource_model';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('directory_region_district', 'district_id');
        $this->_useIsObjectNew = true;
    }
}
