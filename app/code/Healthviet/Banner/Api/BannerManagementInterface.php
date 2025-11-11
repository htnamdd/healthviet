<?php

namespace Healthviet\Banner\Api;

use Healthviet\Banner\Api\Request\BannerRequestInterface;

interface BannerManagementInterface
{
    /**
     * @param \Healthviet\Banner\Api\Request\BannerRequestInterface $params
     * @return \Healthviet\Banner\Api\Data\BannerInterface[]
     */
    public function getBySlider(BannerRequestInterface $params);

    /**
     * @param \Healthviet\Banner\Api\Request\BannerRequestInterface $params
     * @return \Healthviet\Banner\Api\Data\BannerInterface[]
     */
    public function getByCategory(BannerRequestInterface $params);

}
