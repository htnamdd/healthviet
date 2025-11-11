<?php


namespace Healthviet\Banner\Model\ResourceModel\Slider;

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
            \Healthviet\Banner\Model\Slider::class,
            \Healthviet\Banner\Model\ResourceModel\Slider::class
        );
    }
}
