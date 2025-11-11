<?php

namespace Healthviet\OgTags\Model\Blog;

class Post extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialization of Resource Model
     */
    protected function _construct()
    {
        $this->_init(\Healthviet\OgTags\Model\Blog\ResourceModel\Post::class);
    }
}
