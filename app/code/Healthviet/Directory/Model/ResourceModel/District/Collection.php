<?php
declare(strict_types=1);

namespace Healthviet\Directory\Model\ResourceModel\District;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Healthviet\Directory\Model\District as Model;
use Healthviet\Directory\Model\ResourceModel\District as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'directory_region_district_collection';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
