<?php

namespace Healthviet\Blog\Api\Data;

use \Healthviet\Common\Api\Data\CommonResponseInterface;

interface NewsSearchResultsInterface extends CommonResponseInterface
{
    const ITEMS = 'items';

    /**
     * Get news list.
     * @return \Healthviet\Blog\Api\Data\NewsInterface[]
     */
    public function getItems();

    /**
     * Set news list.
     * @param \Healthviet\Blog\Api\Data\NewsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
