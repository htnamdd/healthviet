<?php


namespace Healthviet\Common\Api\Data;


interface MetaDataInterface
{
    const TOTAL = 'total';
    const PAGE_NUM = 'page_index';
    const PAGE_SIZE = 'page_size';

    /**
     * @return mixed
     */
    public function getTotal();

    /**
     * @param int $total
     * @return $this
     */
    public function setTotal($total);

    /**
     * @return mixed
     */
    public function getPageNum();

    /**
     * @param int $pageNum
     * @return $this
     */
    public function setPageNum($pageNum);

    /**
     * @return mixed
     */
    public function getPageSize();

    /**
     * @param int $pageSize
     * @return $this
     */
    public function setPageSize($pageSize);
}
