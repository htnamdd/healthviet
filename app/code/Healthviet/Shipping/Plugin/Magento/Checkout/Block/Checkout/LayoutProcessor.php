<?php

declare(strict_types=1);

namespace Healthviet\Shipping\Plugin\Magento\Checkout\Block\Checkout;

use Magento\Checkout\Block\Checkout\LayoutProcessor as BaseLayoutProcessor;

class LayoutProcessor
{
    /**
     * @param BaseLayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(BaseLayoutProcessor $subject, array $jsLayout): array
    {
        /* SHIPPING ADDRESS */
        $shippingFieldSet = $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
        ['children']['shippingAddress']['children']['shipping-address-fieldset']['children'];

        $shippingFieldSet['district_id'] = [
            'component' => 'Healthviet_Shipping/js/form/element/district',
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'mainScope' => 'shippingAddress',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
            ],
            'filterBy' => [
                'target' => '${ $.provider }:${ $.mainScope }.region_id',
                'field' => 'region_id',
            ],
            'dataScope' => 'shippingAddress.custom_attributes.district_id',
            'provider' => 'checkoutProvider',
            'label' => __('District'),
            'visible' => true,
            'validation' => [
                'required-entry' => true,
            ],
            'source' => 'shippingAddress.custom_attributes.district_id',
            'imports' => [
                'initialOptions' => 'index = ${ $.provider }:dictionaries.district_id',
                'setOptions' => 'index = ${ $.provider }:dictionaries.district_id'
            ],

            'sortOrder' => 100,
        ];

        $shippingFieldSet['district'] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input'
            ],
            'dataScope' => 'shippingAddress.custom_attributes.district',
            'source' => 'shippingAddress.custom_attributes.district',
            'label' => __('District'),
            'provider' => 'checkoutProvider',
            'validation' => [
                'required-entry' => true,
            ],
            'sortOrder' => 100,
            'filterBy' => null,
            'customEntry' => null,
            'visible' => false
        ];

        $shippingFieldSet['ward_id'] = [
            'component' => 'Healthviet_Shipping/js/form/element/ward',
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
                'mainScope' => 'shippingAddress',
            ],
            'filterBy' => [
                'target' => '${ $.provider }:${ $.parentScope }.district_id',
                'field' => 'district_id',
            ],
            'dataScope' => 'shippingAddress.custom_attributes.ward_id',
            'provider' => 'checkoutProvider',
            'label' => __('Ward'),
            'visible' => true,
            'validation' => [
                'required-entry' => true,
            ],
            'source' => 'shippingAddress.custom_attributes.ward_id',
            'imports' => [
                'initialOptions' => 'index = ${ $.provider }:dictionaries.ward_id',
                'setOptions' => 'index = ${ $.provider }:dictionaries.ward_id'
            ],
            'sortOrder' => 110,
        ];

        $shippingFieldSet['ward'] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input'
            ],
            'dataScope' => 'shippingAddress.custom_attributes.ward',
            'source' => 'shippingAddress.custom_attributes.ward',
            'label' => __('Ward'),
            'provider' => 'checkoutProvider',
            'validation' => [
                'required-entry' => true,
            ],
            'sortOrder' => 110,
            'filterBy' => null,
            'customEntry' => null,
            'visible' => false
        ];

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
        ['children']['shippingAddress']['children']['shipping-address-fieldset']['children'] = $shippingFieldSet;

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['country_id']['visible'] = 0;
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['city']['visible'] = 0;

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['postcode']['visible'] = 0;
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['telephone']['validation'] = [];
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['telephone']['validation']['validate-number'] = true;
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['telephone']['validation']['validate-exact-length'] = 10;

        return $jsLayout;
    }
}
