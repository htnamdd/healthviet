<?php


namespace Healthviet\Banner\Model\Data;

use Healthviet\Banner\Api\Data\BannerInterface;

class Banner extends \Magento\Framework\Api\AbstractExtensibleObject implements BannerInterface
{

    /**
     * Get banner_id
     * @return string|null
     */
    public function getBannerId()
    {
        return $this->_get(self::BANNER_ID);
    }

    /**
     * Set banner_id
     * @param string $bannerId
     * @return \Healthviet\Banner\Api\Data\BannerInterface
     */
    public function setBannerId($bannerId)
    {
        return $this->setData(self::BANNER_ID, $bannerId);
    }

    /**
     * Get title
     * @return string|null
     */
    public function getTitle()
    {
        return $this->_get(self::TITLE);
    }

    /**
     * Set title
     * @param string $title
     * @return \Healthviet\Banner\Api\Data\BannerInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Healthviet\Banner\Api\Data\BannerExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Healthviet\Banner\Api\Data\BannerExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Healthviet\Banner\Api\Data\BannerExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get subtitle
     * @return string|null
     */
    public function getSubtitle()
    {
        return $this->_get(self::SUBTITLE);
    }

    /**
     * Set subtitle
     * @param string $subtitle
     * @return \Healthviet\Banner\Api\Data\BannerInterface
     */
    public function setSubtitle($subtitle)
    {
        return $this->setData(self::SUBTITLE, $subtitle);
    }

    /**
     * Get enable
     * @return string|null
     */
    public function getEnable()
    {
        return $this->_get(self::ENABLE);
    }

    /**
     * Set enable
     * @param string $enable
     * @return \Healthviet\Banner\Api\Data\BannerInterface
     */
    public function setEnable($enable)
    {
        return $this->setData(self::ENABLE, $enable);
    }

    /**
     * Get url_redirect
     * @return string|null
     */
    public function getUrlRedirect()
    {
        return $this->_get(self::URL_REDIRECT);
    }

    /**
     * Set url_redirect
     * @param string $urlRedirect
     * @return \Healthviet\Banner\Api\Data\BannerInterface
     */
    public function setUrlRedirect($urlRedirect)
    {
        return $this->setData(self::URL_REDIRECT, $urlRedirect);
    }

    /**
     * Get show_title
     * @return string|null
     */
    public function getShowTitle()
    {
        return $this->_get(self::SHOW_TITLE);
    }

    /**
     * Set show_title
     * @param string $showTitle
     * @return \Healthviet\Banner\Api\Data\BannerInterface
     */
    public function setShowTitle($showTitle)
    {
        return $this->setData(self::SHOW_TITLE, $showTitle);
    }

    /**
     * Get target
     * @return string|null
     */
    public function getTarget()
    {
        return $this->_get(self::TARGET);
    }

    /**
     * Set target
     * @param string $target
     * @return \Healthviet\Banner\Api\Data\BannerInterface
     */
    public function setTarget($target)
    {
        return $this->setData(self::TARGET, $target);
    }

    /**
     * Get image
     * @return string|null
     */
    public function getImage()
    {
        return $this->_get(self::IMAGE);
    }

    /**
     * Set image
     * @param string $image
     * @return \Healthviet\Banner\Api\Data\BannerInterface
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * Get sort_order
     * @return string|null
     */
    public function getSortOrder()
    {
        return $this->_get(self::SORT_ORDER);
    }

    /**
     * Set sort_order
     * @param string $sortOrder
     * @return \Healthviet\Banner\Api\Data\BannerInterface
     */
    public function setSortOrder($sortOrder)
    {
        return $this->setData(self::SORT_ORDER, $sortOrder);
    }

    /**
     * Get slider_id
     * @return string|null
     */
    public function getSliderId()
    {
        return $this->_get(self::SLIDER_ID);
    }

    /**
     * Set slider_id
     * @param string $sliderId
     * @return \Healthviet\Banner\Api\Data\BannerInterface
     */
    public function setSliderId($sliderId)
    {
        return $this->setData(self::SLIDER_ID, $sliderId);
    }

    /**
     * Get icon
     * @return string|null
     */
    public function getIcon()
    {
        return $this->_get(self::ICON);
    }

    /**
     * Set icon
     * @param string $icon
     * @return \Healthviet\Banner\Api\Data\BannerInterface
     */
    public function setIcon($icon)
    {
        return $this->setData(self::ICON, $icon);
    }
}
