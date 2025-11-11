<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */

namespace Magefan\OgTags\Block\Catalog;

use Magefan\OgTags\Block\AbstractOg;

/**
 * Class Category
 * @package Magefan\OgTags\Block\Catalog
 */
class Category extends AbstractOg
{
    /**
     * @var string
     */
    protected $entityType = 'category';

    /**
     * @return mixed
     */
    public function getOgImage()
    {
        $ogImage = $this->getEntity()->getMagefanOgImage() ?: $this->getEntity()->getImage();
        if ($ogImage) {
            
            // in case when old image uploader used and images was saved in catalog/category
            if (false === strpos($ogImage, '/media/')) {
                $ogImage = 'catalog/category/' . $ogImage;
            } else {
                $ogImage = str_replace('/media/', '', $ogImage);
            }

            return $this->getMediaUrl($ogImage);
        } else {
            return $this->getDefaultOgImage();
        }
    }

    /**
     * @return mixed
     */
    public function getOgImagePath()
    {
        $ogImage = $this->getEntity()->getMagefanOgImage() ?: $this->getEntity()->getImage();
        if ($ogImage) {
            if (false === strpos($ogImage, '/media/')) {
                $ogImage = 'catalog/category/' . $ogImage;
            } else {
                $ogImage =  str_replace('/media/', '', $ogImage);
            }
            return $this->getMediaPath($ogImage);
        } else {
            return $this->getDefaultOgImagePath();
        }
    }
}
