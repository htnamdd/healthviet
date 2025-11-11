<?php

namespace Healthviet\OgTags\Model\Blog\ResourceModel\Post;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Initialization of collection
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init(
            \Healthviet\OgTags\Model\Blog\Post::class,
            \Healthviet\OgTags\Model\Blog\ResourceModel\Post::class
        );
    }
}
