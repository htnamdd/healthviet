<?php
declare(strict_types=1);

namespace Healthviet\Directory\Model\ResourceModel\Ward;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Healthviet\Directory\Model\ResourceModel\Ward as ResourceModel;
use Healthviet\Directory\Model\Ward as Model;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'directory_district_ward_collection';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
