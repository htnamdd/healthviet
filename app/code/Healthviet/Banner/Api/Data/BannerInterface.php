<?php


namespace Healthviet\Banner\Api\Data;

interface BannerInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const ENABLE = 'enable';
    const SUBTITLE = 'subtitle';
    const URL_REDIRECT = 'url_redirect';
    const SHOW_TITLE = 'show_title';
    const ICON = 'icon';
    const SORT_ORDER = 'sort_order';
    const IMAGE = 'image';
    const TARGET = 'target';
    const BANNER_ID = 'banner_id';
    const TITLE = 'title';
    const SLIDER_ID = 'slider_id';

    /**
     * Get banner_id
     * @return string|null
     */
    public function getBannerId();

    /**
     * Set banner_id
     * @param string $bannerId
     * @return \Healthviet\Banner\Api\Data\BannerInterface
     */
    public function setBannerId($bannerId);

    /**
     * Get title
     * @return string|null
     */
    public function getTitle();

    /**
     * Set title
     * @param string $title
     * @return \Healthviet\Banner\Api\Data\BannerInterface
     */
    public function setTitle($title);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Healthviet\Banner\Api\Data\BannerExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Healthviet\Banner\Api\Data\BannerExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Healthviet\Banner\Api\Data\BannerExtensionInterface $extensionAttributes
    );

    /**
     * Get subtitle
     * @return string|null
     */
    public function getSubtitle();

    /**
     * Set subtitle
     * @param string $subtitle
     * @return \Healthviet\Banner\Api\Data\BannerInterface
     */
    public function setSubtitle($subtitle);

    /**
     * Get enable
     * @return string|null
     */
    public function getEnable();

    /**
     * Set enable
     * @param string $enable
     * @return \Healthviet\Banner\Api\Data\BannerInterface
     */
    public function setEnable($enable);

    /**
     * Get url_redirect
     * @return string|null
     */
    public function getUrlRedirect();

    /**
     * Set url_redirect
     * @param string $urlRedirect
     * @return \Healthviet\Banner\Api\Data\BannerInterface
     */
    public function setUrlRedirect($urlRedirect);

    /**
     * Get show_title
     * @return string|null
     */
    public function getShowTitle();

    /**
     * Set show_title
     * @param string $showTitle
     * @return \Healthviet\Banner\Api\Data\BannerInterface
     */
    public function setShowTitle($showTitle);

    /**
     * Get target
     * @return string|null
     */
    public function getTarget();

    /**
     * Set target
     * @param string $target
     * @return \Healthviet\Banner\Api\Data\BannerInterface
     */
    public function setTarget($target);

    /**
     * Get image
     * @return string|null
     */
    public function getImage();

    /**
     * Set image
     * @param string $image
     * @return \Healthviet\Banner\Api\Data\BannerInterface
     */
    public function setImage($image);

    /**
     * Get sort_order
     * @return string|null
     */
    public function getSortOrder();

    /**
     * Set sort_order
     * @param string $sortOrder
     * @return \Healthviet\Banner\Api\Data\BannerInterface
     */
    public function setSortOrder($sortOrder);

    /**
     * Get slider_id
     * @return string|null
     */
    public function getSliderId();

    /**
     * Set slider_id
     * @param string $sliderId
     * @return \Healthviet\Banner\Api\Data\BannerInterface
     */
    public function setSliderId($sliderId);

    /**
     * Get icon
     * @return string|null
     */
    public function getIcon();

    /**
     * Set icon
     * @param string $icon
     * @return \Healthviet\Banner\Api\Data\BannerInterface
     */
    public function setIcon($icon);
}
