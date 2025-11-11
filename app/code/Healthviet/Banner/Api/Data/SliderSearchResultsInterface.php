<?php


namespace Healthviet\Banner\Api\Data;

interface SliderSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Slider list.
     * @return \Healthviet\Banner\Api\Data\SliderInterface[]
     */
    public function getItems();

    /**
     * Set title list.
     * @param \Healthviet\Banner\Api\Data\SliderInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
