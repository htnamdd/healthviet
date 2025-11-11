<?php

namespace Healthviet\Banner\Model\ResourceModel\Banner\Collection;

class BannerOfSlider extends \Healthviet\Banner\Model\ResourceModel\Collection\Banner\AbstractCollection
{
    public function createCollection()
    {
        $collection = $this->bannerCollectionFactory->create();
        $collection->getSelect()
            ->join('healthviet_banner_slider','main_table.slider_id = healthviet_banner_slider.slider_id',[])
            ->where('healthviet_banner_slider.slider_code = \''.$this->params['slider_code'].'\'')
            ->where('main_table.enable = 1');
        return $collection;
    }
}
