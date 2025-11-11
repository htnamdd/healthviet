<?php

namespace Healthviet\Banner\Api\Request;

interface BannerRequestInterface
{
    /**
     * @return string
     */
    public function getType();

    /**
     * @param string $type
     * @return mixed
     */
    public function setType($type);

    /**
     * @return string
     */
    public function getSliderCode();

    /**
     * @param string $sliderCode
     * @return mixed
     */
    public function setSliderCode($sliderCode);

    /**
     * @return int
     */
    public function getCatId();

    /**
     * @param int $catId
     * @return mixed
     */
    public function setCatId($catId);
}
