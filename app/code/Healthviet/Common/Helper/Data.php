<?php

namespace Healthviet\Common\Helper;

use Magento\Framework\Exception\NoSuchEntityException;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * const TYPE_IMAGE_ALLOW
     */
    const TYPE_IMAGE_ALLOW = 'healthviet_general/general/types_allow';

    /**
     * const IMAGE_SIZE_LIMIT
     */
    const IMAGE_SIZE_LIMIT = 'healthviet_general/general/maximum_size_allow';

    /**
     * const IMAGE_BANNER_MAX_WIDTH
     */
    const IMAGE_BANNER_MAX_WIDTH = 'healthviet_general/banner/maximum_width';

    /**
     * const IMAGE_BANNER_MAX_HEIGHT
     */
    const IMAGE_BANNER_MAX_HEIGHT = 'healthviet_general/banner/maximum_height';

    const IMAGE_BANNER_ICON_MAX_WIDTH = "healthviet_general/banner/maximum_icon_width";

    const IMAGE_BANNER_ICON_MAX_HEIGHT = "healthviet_general/banner/maximum_icon_height";

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var $baseUrl
     */
    protected $baseUrl;

    /**
     * @var $baseMediaUrl
     */
    protected static $baseMediaUrl;

    /**
     * @var \Magento\Framework\DB\Adapter\AdapterInterface
     */
    protected $connection;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $resource;

    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $filterProvider;

    /**
     * Data constructor.
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\ResourceConnection $resource
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider
    ) {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->storeManager = $storeManager;
        $this->connection = $resource->getConnection();
        $this->resource = $resource;
        $this->filterProvider = $filterProvider;
    }

    /**
     * @param $configPath
     * @return mixed
     */
    public function getValue($configPath)
    {
        return $this->scopeConfig->getValue($configPath, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBaseUrl()
    {
        if ($this->baseUrl == null) {
            $this->baseUrl = $this->storeManager->getStore()->getBaseUrl();
        }
        return $this->baseUrl;
    }

    /**
     * @return mixed
     */
    public static function getMediaUrl()
    {
        if (self::$baseMediaUrl == null) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
            self::$baseMediaUrl = $storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        }
        return self::$baseMediaUrl;
    }

    /**
     * @param $maxHeight
     * @param $maxWidth
     * @return string|null
     */
    public function validateImage($maxHeight, $maxWidth)
    {
        $notice = null;
        $maxHeight = $this->getValue($maxHeight);
        $maxWidth = $this->getValue($maxWidth);
        if (isset($maxWidth) & isset($maxHeight)) {
            $resolutionAllow = $maxWidth . 'x' . $maxHeight;
        }
        if (isset($resolutionAllow)) {
            $notice = 'Allowed maximum image resolution: ' . $resolutionAllow;
        }
        return $notice;
    }

    /**
     * @param $table
     * @param $data
     * @return bool|int
     */
    public function insertMultiple($table, $data)
    {
        try {
            $tableName = $this->resource->getTableName($table);
            return $this->connection->insertMultiple($tableName, $data);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $table
     * @param $data
     * @return bool|int
     */
    public function insert($table, $data)
    {
        try {
            $tableName = $this->resource->getTableName($table);
            return $this->connection->insert($tableName, $data);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $table
     * @param $field
     * @param $id
     * @return bool|int
     */
    public function delete($table, $field, $id)
    {
        try {
            $tableName = $this->resource->getTableName($table);
            return $this->connection->delete($tableName, $field . '=' . $id);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $fileName
     * @return string
     */
    public function convertImageBase64($fileName)
    {
        // Get the image and convert into string
        $img = file_get_contents($fileName);

        // Encode the image string data into base64
        return base64_encode($img);
    }

    public function isMobileDevice()
    {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }

    /**
     * @param $content
     * @return string
     * @throws \Exception
     */
    public function buildAttrHtml($content)
    {
        return $this->filterProvider->getPageFilter()->filter($content);
    }
}
