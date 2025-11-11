<?php

namespace Healthviet\OgTags\Observer\Blog\Block\Adminhtml\Post\Edit\Tab;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class Meta implements ObserverInterface {

    public function execute(Observer $observer)
    {
        $form = $observer->getForm();
        $fieldset = $form->getElement('meta_fieldset');

        $fieldset->addField(
            'magefan_og_title',
            'text',
            [
                'name' => 'magefan_og_title',
                'label' => __('OG Title'),
                'title' => __('OG Title'),

            ]
        );

        $fieldset->addField(
            'magefan_og_description',
            'textarea',
            [
                'name' => 'magefan_og_description',
                'label' => __('OG Description'),
                'title' => __('OG Description'),

            ]
        );

        return $form;
    }
}
