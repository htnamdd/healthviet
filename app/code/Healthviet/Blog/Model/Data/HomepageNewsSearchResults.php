<?php

namespace Healthviet\Blog\Model\Data;

use Healthviet\Blog\Api\Data\HomepageNewsSearchResultsInterface;

class HomepageNewsSearchResults extends \Magento\Framework\Api\AbstractExtensibleObject implements HomepageNewsSearchResultsInterface
{
    /**
     * @return \Healthviet\Blog\Api\Data\HomepageNewsInterface
     */
    public function getItems() {
        return $this->_get(self::ITEMS);
    }

    /**
     * @param \Healthviet\Blog\Api\Data\HomepageNewsInterface $items
     * @return HomepageNewsSearchResults
     */
    public function setItems(\Healthviet\Blog\Api\Data\HomepageNewsInterface $items)
    {
        return $this->setData(self::ITEMS, $items);
    }

    /**
     * @return \Healthviet\Common\Api\Data\ErrorInterface
     */
    public function getError()
    {
        return $this->_get(self::ERROR);
    }

    /**
     * @param \Healthviet\Common\Api\Data\ErrorInterface $error
     * @return HomepageNewsSearchResults
     */
    public function setError(\Healthviet\Common\Api\Data\ErrorInterface $error)
    {
        return $this->setData(self::ERROR, $error);
    }

    /**
     * @return \Healthviet\Common\Api\Data\MetaDataInterface
     */
    public function getMetaData()
    {
        return $this->_get(self::META_DATA);
    }

    /**
     * @param \Healthviet\Common\Api\Data\MetaDataInterface $metaData
     * @return HomepageNewsSearchResults
     */
    public function setMetaData(\Healthviet\Common\Api\Data\MetaDataInterface $metaData)
    {
        return $this->setData(self::META_DATA, $metaData);
    }
}
