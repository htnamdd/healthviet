<?php
/**
 * Created by PhpStorm.
 * User: fzenky
 * Date: 17/01/2019
 * Time: 17:19
 */

namespace Healthviet\Banner\Model\Uploader;

class BannerImage extends \Healthviet\Common\Model\AbstractImageUploader
{

    public function __construct(
        \Magento\MediaStorage\Helper\File\Storage\Database $coreFileStorageDatabase,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Healthviet\Common\Helper\Data $healthvietConfiguration,
        \Psr\Log\LoggerInterface $logger)
    {
        parent::__construct($coreFileStorageDatabase, $filesystem, $uploaderFactory, $storeManager, $healthvietConfiguration, $logger);

        $maxWidth = $this->healthvietConfiguration->getValue(\Healthviet\Common\Helper\Data::IMAGE_BANNER_MAX_WIDTH);
        $maxHeight = $this->healthvietConfiguration->getValue(\Healthviet\Common\Helper\Data::IMAGE_BANNER_MAX_HEIGHT);
        if ($maxWidth && $maxHeight) {
            $this->setImageSizeLimit($maxWidth, $maxHeight);
        }
    }
}
