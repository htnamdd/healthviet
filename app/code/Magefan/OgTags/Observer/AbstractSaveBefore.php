<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */

namespace Magefan\OgTags\Observer;

/**
 * Class AbstractSaveBefore
 * @package Magefan\OgTags\Observer\Blog\Adminhtml\Category
 */
abstract class AbstractSaveBefore
{
    /**
     * @var string
     */
    const BASE_MEDIA_PATH = 'magefan_og';

    /**
     * @var mixed
     */
    protected $ogFactory;

    /**
     * @var String
     */
    protected $field;

    /**
     * AbstractSaveBefore constructor.
     * @param null $ogFactory
     * @param null $field
     */
    public function __construct(
        $ogFactory,
        $field = null
    ) {
        $this->ogFactory = $ogFactory;
        $this->field = $field;
    }

    /**
     * @param \Magento\Framework\Model\AbstractModel $model
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Magento\Framework\Model\AbstractModel $model
    ) {

        if (!$model->getId()) {
            return;
        }

        $ogModel = $this->ogFactory->create();
        $ogModel->load($model->getId(), $this->field);
        $ogModel->setData($this->field, $model->getId());

        $ogModel->setMagefanOgTitle($model->getMagefanOgTitle());
        $ogModel->setMagefanOgDescription($model->getMagefanOgDescription());

        $file = $model->getMagefanOgImageUi();
        
        if ($file && is_array($file)) {
            if (!isset($file[0]['id'])) {
                $ogModel->setMagefanOgImage('');
            } else {
                if ($file[0]['name'] && isset($file[0]['tmp_name'])) {
                    $ogModel->setMagefanOgImage($file[0]['name']);

                    $imageUploader = \Magento\Framework\App\ObjectManager::getInstance()->get(
                        \Magefan\OgTags\ImageUpload::class
                    );

                    $image = $imageUploader->moveFileFromTmp($file[0]['name'], true);
                    $ogModel->setMagefanOgImage('/media/' . $image);
                } else {
                    if (isset($file[0]['url']) && false !== strpos($file[0]['url'], '/media/')) {
                        $url = $file[0]['url'];

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

                        $ogModel->setMagefanOgImage($path);

                    } elseif (isset($file[0]['name'])) {
                        $ogModel->setMagefanOgImage($file[0]['name']);
                    }
                }
            }
        } else {
            $ogModel->setMagefanOgImage('');
        }

        $ogModel->save();
    }
}
