<?php
declare(strict_types=1);

namespace Healthviet\Directory\Model\ResourceModel\Region;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'region_id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init('Magento\Directory\Model\Region', 'Magento\Directory\Model\ResourceModel\Region');
    }
}
