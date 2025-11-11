<?php

namespace Healthviet\Directory\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Ward extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'directory_district_ward_resource_model';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('directory_district_ward', 'ward_id');
        $this->_useIsObjectNew = true;
    }
}
