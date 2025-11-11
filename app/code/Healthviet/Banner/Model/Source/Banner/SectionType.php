<?php

namespace Healthviet\Banner\Model\Source\Banner;

class SectionType  implements \Magento\Framework\Option\ArrayInterface
{
    const STATIC_BANNER_SECTION ='static-banner';
    const CATEGORY_DETAIL_BANNER_SECTION ='category-detail-banner';
    const LIST_BANNER_OF_CAT_AND_AGENT = 'banner-of-cat-and-agent';
    const LIST_BANNER_OF_SLIDER='banner-of-slider';

    const arrCollectionClass=[
        self::STATIC_BANNER_SECTION=>'Healthviet\Banner\Model\ResourceModel\Banner\Collection\StaticCollection',
        self::CATEGORY_DETAIL_BANNER_SECTION=>'Healthviet\Banner\Model\ResourceModel\Banner\Collection\CategoryDetail',
        self::LIST_BANNER_OF_CAT_AND_AGENT=>'Healthviet\Banner\Model\ResourceModel\Banner\Collection\BannerOfCatAndAgent',
        self::LIST_BANNER_OF_SLIDER=>'Healthviet\Banner\Model\ResourceModel\Banner\Collection\BannerOfSlider',
    ];

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::STATIC_BANNER_SECTION, 'label' => __('Static Banner')],
            ['value' => self::CATEGORY_DETAIL_BANNER_SECTION, 'label' => __('Category detail Banner')],
        ];
    }
}
