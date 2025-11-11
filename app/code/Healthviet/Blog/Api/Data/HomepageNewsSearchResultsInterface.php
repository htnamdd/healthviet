<?php

namespace Healthviet\Blog\Api\Data;

use \Healthviet\Common\Api\Data\CommonResponseInterface;

interface HomepageNewsSearchResultsInterface extends CommonResponseInterface
{
    const ITEMS = 'items';

    /**
     * Get news list.
     * @return \Healthviet\Blog\Api\Data\HomepageNewsInterface
     */
    public function getItems();

    /**
     * Set news list.
     * @param \Healthviet\Blog\Api\Data\HomepageNewsInterface $items
     * @return $this
     */
    public function setItems(\Healthviet\Blog\Api\Data\HomepageNewsInterface $items);
}
