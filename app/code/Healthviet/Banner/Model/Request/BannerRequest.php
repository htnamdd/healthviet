<?php

namespace Healthviet\Banner\Model\Request;

use Magento\Framework\Api\AbstractSimpleObject;

class BannerRequest extends AbstractSimpleObject implements \Healthviet\Banner\Api\Request\BannerRequestInterface
{
    const SLIDER_CODE = 'slider_code';
    const CAT_ID = 'cat_id';
    const TYPE = 'type';

    /**
     * @return string
     */
    public function getType()
    {
        return $this->_get(self::TYPE);
    }

    /**
     * @param string $type
     * @return mixed|void
     */
    public function setType($type)
    {
        $this->setData(self::TYPE, $type);
    }

    /**
     * @return string
     */
    public function getSliderCode()
    {
        return $this->_get(self::SLIDER_CODE);
    }

    /**
     * @param string $sliderCode
     * @return mixed|void
     */
    public function setSliderCode($sliderCode)
    {
        $this->setData(self::SLIDER_CODE, $sliderCode);
    }

    /**
     * @return int
     */
    public function getCatId()
    {
        return $this->_get(self::CAT_ID);
    }

    /**
     * @param int $catId
     * @return mixed|void
     */
    public function setCatId($catId)
    {
        $this->setData(self::CAT_ID, $catId);
    }


}
