<?php
declare(strict_types=1);

namespace Healthviet\CustomerFeedback\Model\ResourceModel\CustomerFeedback;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'customerfeedback_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \Healthviet\CustomerFeedback\Model\CustomerFeedback::class,
            \Healthviet\CustomerFeedback\Model\ResourceModel\CustomerFeedback::class
        );
    }
}

