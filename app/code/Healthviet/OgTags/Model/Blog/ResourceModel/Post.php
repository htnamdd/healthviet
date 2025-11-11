<?php

namespace Healthviet\OgTags\Model\Blog\ResourceModel;

class Post extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialization of table
     */
    protected function _construct()
    {
        $this->_init('magefan_og_blog_post', 'entity_id');
    }
}
