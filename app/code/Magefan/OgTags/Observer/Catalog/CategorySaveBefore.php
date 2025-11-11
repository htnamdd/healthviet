<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */

namespace Magefan\OgTags\Observer\Catalog;

use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\App\Request\Http;

class CategorySaveBefore implements ObserverInterface
{
    /**
     * @var ImageUploader
     */
    protected $imageUploader;

    /**
     * @var Http
     */
    protected $request;

    /**
     * @param ImageUploader $imageUploader
     * @param Http $request
     */
    public function __construct(
        ImageUploader $imageUploader,
        Http $request
    ) {
        $this->imageUploader = $imageUploader;
        $this->request = $request;
    }

    /**
     * Before save catalog category
     * @param  \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $eventImage = $this->request->getParam('magefan_og_image');
        $category = $observer->getEvent()->getCategory();
        if ($eventImage && is_array($eventImage)) {
            if (!empty($eventImage['delete'])) {
                $category->setMagefanOgImage('');
            } else {
                if ($eventImage[0]['name'] && isset($eventImage[0]['tmp_name'])) {
                    $category->setMagefanOgImage($eventImage[0]['name']);
                    $image = $this->imageUploader->moveFileFromTmp($eventImage[0]['name'], true);
                    $category->setMagefanOgImage('/media/' . $image);
                } else {
                    if (isset($eventImage[0]['url']) && false !== strpos($eventImage[0]['url'], '/media/')) {

                        $url = $eventImage[0]['url'];

                        /**
                         *    $url may have two types of values
                         *    /media/.renditions/magefan_blog/a.png
                         *    http://domain.com/media/magefan_blog/tmp/a.png
                         */

                        $keyString = strpos($url, '/.renditions/') !== false ? '/.renditions/' : '/media/';
                        $position = strpos($url, $keyString);

                        $path = substr($url,  $position);

                        if ($keyString == '/.renditions/') {
                            $path = str_replace('/.renditions/', '/media/', $path);
                        }

                        $category->setMagefanOgImage($path);
                    } elseif (isset($eventImage[0]['name'])) {
                        $category->setMagefanOgImage($eventImage[0]['name']);
                    }
                }
            }
        }
    }
}
