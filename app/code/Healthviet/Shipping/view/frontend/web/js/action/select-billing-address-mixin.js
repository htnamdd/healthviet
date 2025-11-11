define([
    'jquery',
    'uiRegistry',
    'Magento_Checkout/js/model/quote',
    'mage/utils/wrapper'
], function ($, registry, quote, wrapper) {
    'use strict';

    return function (selectBillingAddressAction) {
        return wrapper.wrap(selectBillingAddressAction, function (originalAction, billingAddress) {
            let selectedRegionId = billingAddress.regionId,
                region = $('select[name="region_id"] option[value="' + selectedRegionId + '"]').first().text();

            if (region && region !== 'undefined' && billingAddress.region === '') {
                billingAddress.region = region;
            }

            originalAction(billingAddress);
        });
    };
});
