<?php


namespace Healthviet\Common\Model\Data;


use Healthviet\Common\Api\Data\MetaDataInterface;

class MetaData extends \Magento\Framework\Api\AbstractExtensibleObject implements MetaDataInterface
{
    /**
     * @return mixed|null
     */
    public function getTotal() {
        return $this->_get(self::TOTAL);
    }

    /**
     * @param int $total
     * @return MetaData
     */
    public function setTotal($total)
    {
        return $this->setData(self::TOTAL, $total);
    }

    /**
     * @return mixed|null
     */
    public function getPageNum()
    {
        return $this->_get(self::PAGE_NUM);
    }

    /**
     * @param int $pageNum
     * @return MetaData
     */
    public function setPageNum($pageNum)
    {
        return $this->setData(self::PAGE_NUM, $pageNum);
    }

    /**
     * @return mixed|null
     */
    public function getPageSize()
    {
        return $this->_get(self::PAGE_SIZE);
    }

    /**
     * @param int $pageSize
     * @return MetaData
     */
    public function setPageSize($pageSize)
    {
        return $this->setData(self::PAGE_SIZE, $pageSize);
    }
}
