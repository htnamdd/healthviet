/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * @api
 */
define([
    'underscore',
    'uiRegistry',
    'Magento_Ui/js/form/element/select'
], function (_, registry, Select) {
    'use strict';

    return Select.extend({
        defaults: {
            skipValidation: false,
            imports: {
                update: '${ $.parentName }.region_id:value',
                updateRequire: '${ $.parentName }.country_id:value'
            }
        },
        initialize: function () {
            this._super();
            if (!this.source) {
                this.source = registry.get('checkoutProvider');
            }
            var self = this,
                districts = this.source.get('dictionaries').district_id;
            registry.async([this.parentName, 'district_id'].join('.'))(function (Component) {
                Component.value.subscribe(function (value) {
                    registry.async([self.parentName, 'district'].join('.'))(function (uiDistrict) {
                        var district = _.find(districts, {value: value});
                        if (district)
                            uiDistrict.value(district.label);
                    });
                })
            });
            return this;
        },
        /**
         * @param {String} value
         */
        updateRequire: function (value) {
            registry.get(this.customName, function (input) {
                let isDistrictRequired = true;
                input.validation['required-entry'] = isDistrictRequired;
                input.required(isDistrictRequired);
            });
        },
        update: function (value) {
            if (!this.source) {
                this.source = registry.get('checkoutProvider');
            }
            var regions = registry.get(this.parentName + '.' + 'region_id'),
                options = regions.indexedOptions,
                isDistrictRequired,
                option;
            if (!value) {
                return;
            }
            option = options[value];

            if (typeof option === 'undefined') {
                return;
            }

            if (this.skipValidation) {
                this.validation['required-entry'] = false;
                this.required(false);
            } else {
                this.validation['required-entry'] = true;

                if (option && !this.options().length) {
                    registry.get(this.customName, function (input) {
                        isDistrictRequired = true;
                        input.validation['required-entry'] = isDistrictRequired;
                        input.required(isDistrictRequired);
                    });
                }

                this.required(true);
            }
            if (this.source.get(this.customScope) && this.source.get(this.customScope).district_id) {
                this.value(this.source.get(this.customScope).district_id);
            }
        },

        /**
         * Filters 'initialOptions' property by 'field' and 'value' passed,
         * calls 'setOptions' passing the result to it
         *
         * @param {*} value
         * @param {String} field
         */
        filter: function (value, field) {
            var region = registry.get(this.parentName + '.' + 'region_id'),
                option;

            if (region) {
                option = region.indexedOptions[value];

                this._super(value, field);

                if (option && option['is_district_visible'] === false) {
                    // hide select and corresponding text input field if region must not be shown for selected country
                    this.setVisible(false);

                    if (this.customEntry) {// eslint-disable-line max-depth
                        this.toggleInput(false);
                    }
                }
            }
        },
        setInitialValue: function () {
            var self = this;
            registry.async(this.parentName + '.' + 'region_id')(function (ui) {
                if (typeof ui.value() === "undefined" || ui.value() === '') {
                    self.setOptions([]);
                } else {
                    self.filter(ui.value(), 'region_id');
                }
            });
            return this._super();
        }
    });
});

