<?php

namespace Healthviet\Banner\Model\Source\Banner;

class SliderCode implements \Magento\Framework\Option\ArrayInterface
{
    protected $sliderCollection;
    protected $request;
    const ENABLE = 1;

    public function __construct(
        \Healthviet\Banner\Model\ResourceModel\Slider\CollectionFactory $sliderCollection,
        \Magento\Framework\App\RequestInterface $request
    )
    {
        $this->sliderCollection = $sliderCollection;
        $this->request=$request;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $result = [];
        $collection=$this->getCollection();
        foreach ($collection as $slider) {
            $result[] = [
                'value' => $slider->getSliderCode(),
                'label' => __($slider->getTitle())
            ];
        }
        return $result;
    }

    protected function getCollection(){
        $collection = $this->sliderCollection->create();
        $currentSliderId=$this->request->getParam('current_slider_id');
        if($currentSliderId){
            $collection->addFieldToFilter('slider_id',$currentSliderId);
        }
        return $collection;
    }
}
