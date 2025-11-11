<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */

namespace Magefan\OgTags\Block;

use \Magento\Framework\View\Element\AbstractBlock;
use \Magento\Framework\View\Element\Context;
use \Magento\Store\Model\StoreManagerInterface;
use \Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class AbstractOg
 * @package Magefan\OgTags\Block
 */
class AbstractOg extends AbstractBlock
{
    /**
     * OG enabled path in system.xml
     */
    const XML_PATH_ENABLED = 'mfogt/general/enabled';

    /**
     * OG use on pages path in system.xml
     */
    const XML_PATH_USE_FOR = 'mfogt/general/use_og_meta_tag_for';

    /**
     * Facebook App ID path in system.xml
     */
    const XML_PATH_FB_APP_ID = 'mfogt/general/fbappid';

    /**
     * Default OG Image path in system.xml
     */
    const XML_PATH_DEFAULT_OG_IMAGE = 'mfogt/general/upload_image_id';

    /**
     * Default OG description path in system.xml
     */
    const XML_PATH_DEFAULT_OG_DESCRIPTION = 'mfogt/general/description';

    /**
     * Store view locale code in system.xml
     */
    const XML_PATH_LOCALE_CODE = 'general/locale/code';

    /**
     * @var mixed
     */
    protected $entity;

    /**
     * @var string
     */
    protected $entityType;

     /**
      * @var \Magento\Framework\Registry
      */
    protected $registry;

    /**
     * @var \Magento\Framework\View\Page\Config
     */
    protected $pageConfig;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\Filesystem|null
     */
    protected $filesystem;

    /**
     * AbstractOg constructor.
     * @param Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\View\Page\Config $pageConfig
     * @param StoreManagerInterface $storeManager
     * @param array $data
     * @param \Magento\Framework\Filesystem|null $filesystem
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\View\Page\Config $pageConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = [],
        \Magento\Framework\Filesystem $filesystem = null

    ) {
        $this->registry = $registry;
        $this->pageConfig = $pageConfig;
        $this->storeManager = $storeManager;

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $this->filesystem = $filesystem ?: $objectManager->get(
            \Magento\Framework\Filesystem::class
        );

        parent::__construct($context, $data);
    }

    /**
     * @return bool|mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getEntity()
    {
        if (null === $this->entity) {
            $this->entity = false;
            if ($this->entityType == 'cms_page') {
                $pageBlock = $this->getLayout()->getBlock('cms_page');
                if ($pageBlock) {
                    $this->entity = $pageBlock->getPage();
                }
            } else {
                $this->entity = $this->registry->registry('current_' . $this->entityType);
            }
        }

        return $this->entity;
    }

    /**
     * @param $path
     * @return mixed
     */
    public function getConfigValue($path)
    {
        return $this->_scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getOgTitle()
    {
        return $this->getEntity()->getMagefanOgTitle() ?: $this->pageConfig->getTitle()->get();
    }

    /**
     * @return mixed
     */
    public function getOgDescription()
    {
        $description = $this->getEntity()->getMagefanOgDescription() ?: html_entity_decode((string)$this->pageConfig->getDescription());
        if (!$description) {
            $description = $this->getDefaultOgDescription();
        }

        return $description;
    }

    /**
     * @return string
     */
    public function getDefaultOgDescription()
    {
        return $this->getConfigValue(static::XML_PATH_DEFAULT_OG_DESCRIPTION);
    }

    /**
     * @return mixed
     */
    public function getOgImage()
    {
        $ogImage = $this->getEntity()->getMagefanOgImage();
        if ($ogImage) {
            return  $this->getMediaUrl($ogImage);
        } else {
            return $this->getDefaultOgImage();
        }
    }


    /**
     * @return string
     */
    public function getDefaultOgImage()
    {
        if ($ogImage = $this->getConfigValue(static::XML_PATH_DEFAULT_OG_IMAGE)) {
            $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
            if (!$mediaDirectory->isExist($ogImage)){
                $ogImage = 'default/' . $ogImage;
            }

            return $this->getMediaUrl($ogImage);
        }
    }

    /**
     * @param $path
     * @return string
     */
    public function getMediaUrl($path)
    {

        if (false !== strpos($path , '/media/')){
            $path = substr($path, strpos($path, "/media/", strlen("/media/")) + strlen("/media/"), strlen($path));
        }

        return $this->storeManager->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $path;
    }

    /**
     * @return mixed
     */
    public function getOgImagePath()
    {
        $ogImage = $this->getEntity()->getMagefanOgImage();

        if ($ogImage) {
            return  $this->getMediaPath($ogImage);
        } else {
            return $this->getDefaultOgImagePath();
        }
    }

    /**
     * @return string
     */
    public function getDefaultOgImagePath()
    {
        if ($ogImage = $this->getConfigValue(static::XML_PATH_DEFAULT_OG_IMAGE)) {
            $ogImage = trim($ogImage, '/');
            return $this->getMediaPath( 'default/' . $ogImage);
        }
    }

    /**
     * @return string
     */
    public function getMediaPath($path)
    {
        $tmpPath = explode('/',  ltrim($path, '/'));

        if (isset($tmpPath[0]) && $tmpPath[0] == 'media') {
            unset($tmpPath[0]);

            $path = implode('/', $tmpPath);
        }

        return $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath() . $path;
    }

    /**
     * @return array|bool
     */
    public function getOgImagSize()
    {
        $path = $this->getOgImagePath();

        if ($path && file_exists($path)) {
            $size = getimagesize($path);
            if ($size && count($size) > 1) {
                return [
                    (int) $size[0],
                    (int) $size[1],
                ];
            }
        }

        return false;
    }

    /**
     * @return string
     */
    public function getOgType()
    {
        return 'website';
    }

    /**
     * @return mixed
     */
    public function getFbAppId()
    {
        return $this->getConfigValue(self::XML_PATH_FB_APP_ID);
    }

    /**
     * @return mixed
     */
    public function getOgUrl()
    {
        $store = $this->storeManager->getStore();
        $storeCode = $store->getCode();
        $url = $store->getCurrentUrl(false);
        $url = urldecode($url);
        $url = str_replace('___store=' . $storeCode, '', $url);
        if ($store->isDefault()) {
            $url = str_replace('/' . $storeCode . '/', '/', $url);
        }
        $url  = str_replace('&amp;', '&', $url);
        $url = trim($url, '?&');
        return $url;
    }

    /**
     * @return mixed
     */
    public function getCurrentCurrencyCode()
    {
        return $this->storeManager->getStore()->getCurrentCurrency()->getCode();
    }

    /**
     * @return string
     */
    public function getAdditionalAttributes()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getOgHtml()
    {

        $metaOg = PHP_EOL;
        $fbAppId = $this->escapeHtml($this->stripTags($this->getFbAppId()));
        $ogType = $this->escapeHtml($this->stripTags($this->getOgType()));
        $ogTitle = $this->escapeHtml($this->stripTags($this->getOgTitle()));
        $ogDescription = $this->escapeHtml($this->stripTags($this->getOgDescription()));
        $ogImage = $this->escapeHtml($this->stripTags($this->getOgImage()));
        $ogUrl = $this->escapeHtml($this->stripTags($this->getOgUrl()));
        $additional = $this->getAdditionalAttributes();


        if ($fbAppId) {
            $metaOg .= '<meta property="fb:app_id" content="' . $fbAppId . '" />' . PHP_EOL;
        }

        if ($ogType) {
            $metaOg .= '<meta property="og:type" content="' . $ogType . '" />' . PHP_EOL;
        }
        if ($ogTitle) {
            $metaOg .= '<meta property="og:title" content="' . $ogTitle . '" />' . PHP_EOL;
        }
        if ($ogDescription) {
            $metaOg .= '<meta property="og:description" content="' . $ogDescription . '" />' . PHP_EOL;
        }
        if ($ogImage) {

            $size = $this->getOgImagSize();
            if ($size) {
                list($width, $height) = $size;

                $metaOg .= '<meta property="og:image:width" content="' . $this->escapeHtml($this->stripTags($width)) . '" />' . PHP_EOL;
                $metaOg .= '<meta property="og:image:height" content="' . $this->escapeHtml($this->stripTags($height)) . '" />' . PHP_EOL;
            }
            $metaOg .= '<meta property="og:image" content="' . $ogImage . '" />' . PHP_EOL;
            $metaOg .= '<meta property="og:image:secure_url" content="' . $ogImage . '" />' . PHP_EOL;
        }
        if ($ogUrl) {
            $metaOg .= '<meta property="og:url" content="' . $ogUrl . '" />' . PHP_EOL;
        }

        $locale = $this->getConfigValue(self::XML_PATH_LOCALE_CODE);
        if ($locale) {
            $metaOg .= '<meta property="og:locale" content="' . $locale . '" />' . PHP_EOL;
        }


        if ($additional) {
            $metaOg .= $additional;
        }
        return $metaOg;
    }

    /**
     * @return mixed
     */
    protected function _toHtml()
    {
        if ($this->getConfigValue(self::XML_PATH_ENABLED)
            && in_array($this->entityType, explode(',', $this->getConfigValue(self::XML_PATH_USE_FOR)))
            && $this->getEntity()
        ) {
            return $this->getOgHtml();
        }

        return false;
    }
}
