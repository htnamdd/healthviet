<?php

namespace Healthviet\Rule\Model\Condition\Sql;

use Magento\Eav\Model\Entity\Collection\AbstractCollection;
use Magento\Rule\Model\Condition\Combine;

class Builder extends \Magento\Rule\Model\Condition\Sql\Builder
{
    /**
     * Attach conditions filter to collection
     *
     * @param AbstractCollection $collection
     * @param Combine $combine
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function attachConditionToCollection(
        AbstractCollection $collection,
        Combine $combine
    ): void {
        $this->_connection = $collection->getResource()->getConnection();
        $this->_joinTablesToCollection($collection, $combine);
        $whereExpression = $this->_getMappedSqlCombination($combine);
        if (!empty($whereExpression)) {
            $collection->getSelect()->where($whereExpression);
        }
    }
}
