<?php


namespace Healthviet\Banner\Model\ResourceModel\Banner;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Healthviet\Banner\Model\Banner::class,
            \Healthviet\Banner\Model\ResourceModel\Banner::class
        );
    }
}
