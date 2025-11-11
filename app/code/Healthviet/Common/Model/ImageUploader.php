<?php
namespace Healthviet\Common\Model;


class ImageUploader extends AbstractImageUploader
{

 public function __construct(
     \Magento\MediaStorage\Helper\File\Storage\Database $coreFileStorageDatabase,
     \Magento\Framework\Filesystem $filesystem,
     \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
     \Magento\Store\Model\StoreManagerInterface $storeManager,
     \Healthviet\Common\Helper\Data $kimnamConfiguration,
     \Psr\Log\LoggerInterface $logger)
 {
     parent::__construct($coreFileStorageDatabase, $filesystem, $uploaderFactory, $storeManager, $kimnamConfiguration, $logger);
 }

}
