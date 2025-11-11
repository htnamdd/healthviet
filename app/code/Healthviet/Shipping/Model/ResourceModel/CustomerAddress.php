<?php

namespace Healthviet\Shipping\Model\ResourceModel;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CustomerAddress extends AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        $this->_init('customer_address_entity', 'entity_id');
    }

    /**
     * @param int $entityId
     * @param array $data
     * @throws LocalizedException
     */
    public function updateAddress(int $entityId, array $data): void
    {
        $connection = $this->getConnection();
        $table = $this->getMainTable();
        $connection->update($table, $data, ['entity_id = ?' => $entityId]);
    }
}
