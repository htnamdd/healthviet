<?php


namespace Healthviet\Banner\Api\Data;

interface BannerSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Banner list.
     * @return \Healthviet\Banner\Api\Data\BannerInterface[]
     */
    public function getItems();

    /**
     * Set title list.
     * @param \Healthviet\Banner\Api\Data\BannerInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
