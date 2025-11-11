define([
    'jquery',
    'uiRegistry',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/shipping-rate-registry',
    'mage/utils/wrapper'
], function ($, registry, quote, rateRegistry, wrapper) {
    'use strict';

    return function (selectShippingAddressAction) {
        return wrapper.wrap(selectShippingAddressAction, function (originalAction, shippingAddress) {
            if (!quote.isVirtual()) {
                rateRegistry.set(shippingAddress.getCacheKey(), null);
            }

            let selectedRegionId = shippingAddress.regionId,
                region = $('select[name="region_id"] option[value="' + selectedRegionId + '"]').first().text();
            if (region && region !== 'undefined' && shippingAddress.region === '') {
                shippingAddress.region = region;
            }
            originalAction(shippingAddress);
        });
    };
});
