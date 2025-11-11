<?php
declare(strict_types=1);

namespace Healthviet\Doctor\Model\ResourceModel\Doctor;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'doctor_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \Healthviet\Doctor\Model\Doctor::class,
            \Healthviet\Doctor\Model\ResourceModel\Doctor::class
        );
    }
}

