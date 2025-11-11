<?php


namespace Healthviet\Banner\Api\Data;

interface SliderInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const SLIDER_ID = 'slider_id';
    const SHOW_TITLE = 'show_title';
    const SLIDER_CODE = 'slider_code';
    const ENABLE = 'enable';
    const TITLE = 'title';

    /**
     * Get slider_id
     * @return string|null
     */
    public function getSliderId();

    /**
     * Set slider_id
     * @param string $sliderId
     * @return \Healthviet\Banner\Api\Data\SliderInterface
     */
    public function setSliderId($sliderId);

    /**
     * Get title
     * @return string|null
     */
    public function getTitle();

    /**
     * Set title
     * @param string $title
     * @return \Healthviet\Banner\Api\Data\SliderInterface
     */
    public function setTitle($title);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Healthviet\Banner\Api\Data\SliderExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Healthviet\Banner\Api\Data\SliderExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Healthviet\Banner\Api\Data\SliderExtensionInterface $extensionAttributes
    );

    /**
     * Get show_title
     * @return string|null
     */
    public function getShowTitle();

    /**
     * Set show_title
     * @param string $showTitle
     * @return \Healthviet\Banner\Api\Data\SliderInterface
     */
    public function setShowTitle($showTitle);

    /**
     * Get enable
     * @return string|null
     */
    public function getEnable();

    /**
     * Set enable
     * @param string $enable
     * @return \Healthviet\Banner\Api\Data\SliderInterface
     */
    public function setEnable($enable);

    /**
     * Get slider_code
     * @return string|null
     */
    public function getSliderCode();

    /**
     * Set slider_code
     * @param string $sliderCode
     * @return \Healthviet\Banner\Api\Data\SliderInterface
     */
    public function setSliderCode($sliderCode);
}
