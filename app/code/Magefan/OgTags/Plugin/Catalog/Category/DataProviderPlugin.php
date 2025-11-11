<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */

namespace Magefan\OgTags\Plugin\Catalog\Category;

use Magento\Catalog\Model\Category\DataProvider;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\UrlInterface;
use Magento\Catalog\Model\Category\FileInfo;

class DataProviderPlugin
{
    const PUB_PATH = 'pub';

    /**
     * Store manager
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var
     */
    private $mediaDirectory;

    /**
     * @var FileInfo
     */
    private $fileInfo;

    /**
     * Constructor
     * @param StoreManagerInterface $storeManager
     * @param Filesystem $filesystem
     * @param FileInfo $fileInfo
     * @throws FileSystemException
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        Filesystem            $filesystem,
        FileInfo              $fileInfo
    )
    {
        $this->storeManager = $storeManager;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::ROOT);
        $this->fileInfo = $fileInfo;
    }

    /**
     * After getting category data
     * @param DataProvider $subject
     * @param array
     * @return array
     * @throws NoSuchEntityException
     */
    public function afterGetData(DataProvider $subject, $result)
    {
        $category = $subject->getCurrentCategory();

        $imageField = 'magefan_og_image';

        if ($category) {
            $categoryData = $result[$category->getId()] ?: $category;

            $file = $category->getData($imageField);

            if ($file && $this->mediaDirectory->isExist(self::PUB_PATH . $file)) {

                $stat = $this->fileInfo->getStat(self::PUB_PATH . $file);
                $mime = $this->fileInfo->getMimeType(self::PUB_PATH . $file);

                $categoryData[$imageField][0]['name'] = basename($file);
                $categoryData[$imageField][0]['url'] = $this->getImageUrl($file);
                $categoryData[$imageField][0]['size'] = $stat['size'];
                $categoryData[$imageField][0]['type'] = $mime;
            }
            $result[$category->getId()] = $categoryData;
        }
        return $result;
    }

    /**
     * Retrieve image url
     * @param string $image
     * @return string
     * @throws NoSuchEntityException
     */
    protected function getImageUrl($image)
    {
        if (is_array($image) && isset($image[0]['url'])) {
            return $image[0]['url'];
        }

        if (false !== strpos($image, '/media/')) {
            $image = str_replace('/media/', '', $image);
        }

        return $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . $image;
    }
}