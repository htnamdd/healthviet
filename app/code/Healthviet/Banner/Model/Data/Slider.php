<?php


namespace Healthviet\Banner\Model\Data;

use Healthviet\Banner\Api\Data\SliderInterface;

class Slider extends \Magento\Framework\Api\AbstractExtensibleObject implements SliderInterface
{

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
     * @return \Healthviet\Banner\Api\Data\SliderInterface
     */
    public function setSliderId($sliderId)
    {
        return $this->setData(self::SLIDER_ID, $sliderId);
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
     * @return \Healthviet\Banner\Api\Data\SliderInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Healthviet\Banner\Api\Data\SliderExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Healthviet\Banner\Api\Data\SliderExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Healthviet\Banner\Api\Data\SliderExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
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
     * @return \Healthviet\Banner\Api\Data\SliderInterface
     */
    public function setShowTitle($showTitle)
    {
        return $this->setData(self::SHOW_TITLE, $showTitle);
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
     * @return \Healthviet\Banner\Api\Data\SliderInterface
     */
    public function setEnable($enable)
    {
        return $this->setData(self::ENABLE, $enable);
    }

    /**
     * Get slider_code
     * @return string|null
     */
    public function getSliderCode()
    {
        return $this->_get(self::SLIDER_CODE);
    }

    /**
     * Set slider_code
     * @param string $sliderCode
     * @return \Healthviet\Banner\Api\Data\SliderInterface
     */
    public function setSliderCode($sliderCode)
    {
        return $this->setData(self::SLIDER_CODE, $sliderCode);
    }
}
