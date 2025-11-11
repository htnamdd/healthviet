<?php

namespace Healthviet\OgTags\Model\Config\Source;

class Pages
{
    public function afterToOptionArray(\Magefan\OgTags\Model\Config\Source\Pages $subject, $result)
    {
        $result[] = ['value' => 'healthviet_blog_post', 'label' => __('Healthviet Blog')];
        return $result;
    }
}
