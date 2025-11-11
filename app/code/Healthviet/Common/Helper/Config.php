<?php

namespace Healthviet\Common\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

/**
 * Class Config
 * @package Healthviet\Common\Helper
 */
class Config extends AbstractHelper
{
    /**
     * const DEFAULT_PRODUCT_IMAGE_URL
     */
    const DEFAULT_PRODUCT_IMAGE_URL = "default/default-avatar.png";

    /**
     * @var $currencySymbol
     */
    protected $currencySymbol;

    /**
     * @var $baseMediaUrl
     */
    protected $baseMediaUrl;

    /**
     * @var $baseUrl
     */
    protected $baseUrl;

    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $priceCurrency;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Config constructor.
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param Context $context
     */
    public function __construct(
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        Context $context
    )
    {
        $this->priceCurrency = $priceCurrency;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function getCurrencySymbol()
    {
        if ($this->currencySymbol == null) {
            $this->currencySymbol = $this->priceCurrency->getCurrency()->getCurrencySymbol();
        }
        return $this->currencySymbol;
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBaseMediaUrl()
    {
        if ($this->baseMediaUrl == null) {
            $this->baseMediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        }
        return $this->baseMediaUrl;
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBaseUrl()
    {
        if ($this->baseUrl == null) {
            $this->baseUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);
        }
        return $this->baseUrl;
    }
}
