<?php

namespace Healthviet\Common\Model;

abstract class AbstractImageUploader
{
    /**
     * @var string $basePath
     */
    public $basePath;

    /**
     * @var \Magento\MediaStorage\Helper\File\Storage\Database
     */
    protected $coreFileStorageDatabase;

    /**
     * @var \Magento\Framework\Filesystem\Directory\WriteInterface
     */
    protected $mediaDirectory;

    /**
     * @var \Magento\MediaStorage\Model\File\UploaderFactory
     */
    protected $uploaderFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var string $baseTmpPath
     */
    protected $baseTmpPath;

    /**
     * @var array $allowedExtensions
     */
    protected $allowedExtensions;

    /**
     * @var $fileSizeLimit
     */
    protected $fileSizeLimit;

    /**
     * @var $widthLimit
     */
    protected $widthLimit;

    /**
     * @var $heightLimit
     */
    protected $heightLimit;

    /**
     * @var $validateImageSize
     */
    protected $validateImageSize;

    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $filesystem;

    /**
     * @var \Healthviet\Common\Helper\Data
     */
    protected $healthvietConfiguration;

    /**
     * AbstractImageUploader constructor.
     * @param \Magento\MediaStorage\Helper\File\Storage\Database $coreFileStorageDatabase
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Healthviet\Common\Helper\Data $healthvietConfiguration
     * @param \Psr\Log\LoggerInterface $logger
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function __construct(
        \Magento\MediaStorage\Helper\File\Storage\Database $coreFileStorageDatabase,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Healthviet\Common\Helper\Data $healthvietConfiguration,
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->healthvietConfiguration = $healthvietConfiguration;
        $this->coreFileStorageDatabase = $coreFileStorageDatabase;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $this->filesystem = $filesystem;
        $this->uploaderFactory = $uploaderFactory;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
        $this->baseTmpPath = 'button/image';
        $this->basePath = 'button/image';
        $typeImageAllow = $this->healthvietConfiguration->getValue(\Healthviet\Common\Helper\Data::TYPE_IMAGE_ALLOW);
        if (isset($typeImageAllow))
            $this->allowedExtensions = explode(',', $typeImageAllow);
    }

    /**
     * @param $width
     * @param $height
     */
    public function setImageSizeLimit($width, $height)
    {
        $this->validateImageSize = true;
        $this->widthLimit = $width;
        $this->heightLimit = $height;
    }

    /**
     * @return mixed
     */
    public function getFileSizeLimit()
    {
        return $this->fileSizeLimit;
    }

    /**
     * @param mixed $fileSizeLimit
     */
    public function setFileSizeLimit($fileSizeLimit)
    {
        $this->fileSizeLimit = $fileSizeLimit;
    }


    /**
     * @param $baseTmpPath
     */
    public function setBaseTmpPath($baseTmpPath)
    {
        $this->baseTmpPath = $baseTmpPath;
    }

    /**
     * @param $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @param $allowedExtensions
     */
    public function setAllowedExtensions($allowedExtensions)
    {
        $this->allowedExtensions = $allowedExtensions;
    }

    /**
     * @return string
     */
    public function getBaseTmpPath()
    {

        return $this->baseTmpPath;
    }

    /**
     * @return string
     */
    public function getBasePath()
    {

        return $this->basePath;
    }

    /**
     * @return array
     */
    public function getAllowedExtensions()
    {

        return $this->allowedExtensions;
    }

    /**
     * @param $path
     * @param $imageName
     * @return string
     */
    public function getFilePath($path, $imageName)
    {

        return rtrim($path, '/') . '/' . ltrim($imageName, '/');
    }

    /**
     * @param $imageName
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function moveFileFromTmp($imageName)
    {
        $baseTmpPath = $this->getBaseTmpPath();
        $basePath = $this->getBasePath();
        $baseImagePath = $this->getFilePath($basePath, $imageName);
        $baseTmpImagePath = $this->getFilePath($baseTmpPath, $imageName);
        $mediaPath = $this->filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath();
        $imagePath = $mediaPath . $baseTmpImagePath;

        if (file_exists($imagePath)) {
            try {
                $this->coreFileStorageDatabase->copyFile(
                    $baseTmpImagePath,
                    $baseImagePath
                );
                $this->mediaDirectory->renameFile(
                    $baseTmpImagePath,
                    $baseImagePath
                );
            } catch (\Exception $e) {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while saving the file(s).')
                );
            }
        }

        return $imageName;
    }

    /**
     * @param $fileId
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function validateFileSize($fileId)
    {
        if (isset($this->fileSizeLimit)) {
            $fileSize = $_FILES[$fileId]['size'];
            if ($this->fileSizeLimit < $fileSize) {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('File to large, can not be saved.')
                );
            }
        }
    }

    /**
     * @param $fileId
     * @return array|bool
     */
    private function getUploadImageSize($fileId)
    {

        return getimagesize($_FILES[$fileId]['tmp_name']);
    }

    /**
     * @param $fileId
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function validateImageSize($fileId)
    {
        if ($this->validateImageSize) {
            list($width, $height) = $this->getUploadImageSize($fileId);
            if ($width > $this->widthLimit || $height > $this->heightLimit) {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Image size to large. Only allow maximum size is ' . $this->widthLimit . 'x' . $this->heightLimit)
                );
            }
        }
    }

    /**
     * @param $fileId
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function saveFileToTmpDir($fileId)
    {
        $this->validateFileSize($fileId);
        $baseTmpPath = $this->getBaseTmpPath();
        $uploader = $this->uploaderFactory->create(['fileId' => $fileId]);
        $uploader->setAllowedExtensions($this->getAllowedExtensions());
        $uploader->setAllowRenameFiles(true);
//        $this->validateImageSize($fileId);

        $result = $uploader->save($this->mediaDirectory->getAbsolutePath($baseTmpPath));

        if (!$result) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('File can not be saved to the destination folder.')
            );
        }

        $result['tmp_name'] = str_replace('\\', '/', $result['tmp_name']);
        $result['path'] = str_replace('\\', '/', $result['path']);
        $result['url'] = $this->storeManager
                ->getStore()
                ->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                ) . $this->getFilePath($baseTmpPath, $result['file']);
        $result['name'] = $result['file'];
        if (isset($result['file'])) {
            try {
                $relativePath = rtrim($baseTmpPath, '/') . '/' . ltrim($result['file'], '/');
                $this->coreFileStorageDatabase->saveFile($relativePath);
            } catch (\Exception $e) {
                $this->logger->critical($e);
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while saving the file(s).')
                );
            }
        }

        return $result;
    }
}
