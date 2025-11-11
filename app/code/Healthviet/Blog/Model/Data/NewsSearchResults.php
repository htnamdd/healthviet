<?php

namespace Healthviet\Blog\Model\Data;

use Healthviet\Blog\Api\Data\NewsSearchResultsInterface;

class NewsSearchResults extends \Magento\Framework\Api\AbstractExtensibleObject implements NewsSearchResultsInterface
{
    /**
     * @return \Healthviet\Blog\Api\Data\NewsInterface[]
     */
    public function getItems() {
        $items = $this->_get(self::ITEMS);
        return is_array($items) ? $items : [];
    }

    /**
     * @param \Healthviet\Blog\Api\Data\NewsInterface[] $items
     * @return NewsSearchResults
     */
    public function setItems(array $items)
    {
        return $this->setData(self::ITEMS, $items);
    }

    /**
     * @return \Healthviet\Common\Api\Data\ErrorInterface|mixed|null
     */
    public function getError()
    {
        return $this->_get(self::ERROR);
    }

    /**
     * @param \Healthviet\Common\Api\Data\ErrorInterface $error
     * @return NewsSearchResults
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
     * @return NewsSearchResults
     */
    public function setMetaData(\Healthviet\Common\Api\Data\MetaDataInterface $metaData)
    {
        return $this->setData(self::META_DATA, $metaData);
    }
}
