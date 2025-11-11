<?php
declare(strict_types=1);

namespace Healthviet\Doctor\Api\Data;

interface DoctorSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Doctor list.
     * @return \Healthviet\Doctor\Api\Data\DoctorInterface[]
     */
    public function getItems();

    /**
     * Set name list.
     * @param \Healthviet\Doctor\Api\Data\DoctorInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

