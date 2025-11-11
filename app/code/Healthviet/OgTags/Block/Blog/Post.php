<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */

namespace Healthviet\OgTags\Block\Blog;

use Magefan\OgTags\Block\AbstractOg;

/**
 * Class Page
 * @package Magefan\OgTags\Block\Cms
 */
class Post extends AbstractOg
{
    /**
     * @var string
     */
    protected $entityType = 'healthviet_blog_post';

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getOgImage()
    {
        return $this->getEntity()->getMagefanOgImage() ?: $this->getEntity()->getImage();
    }

    /**
     * @return mixed
     */
    public function getOgImagePath()
    {
        $ogImage = $this->getEntity()->getMagefanOgImage() ?: $this->getEntity()->getImagePath();
        $ogImage = trim($ogImage ?: '', '/');
        if ($ogImage && $ogImage != 'no_selection') {
            return  $this->getMediaPath($ogImage);
        } else {
            return $this->getDefaultOgImagePath();
        }
    }
}
