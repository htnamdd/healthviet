/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    'mage/template',
    'underscore',
    'jquery/ui',
    'mage/validation',
    'domReady!'
], function ($, mageTemplate, _, ui, validation, url) {
    'use strict';

    $.widget('mage.regionsManager', {
        options: {
            optionTemplate:
                '<option value="<%- data.value %>" <% if (data.isSelected) { %>selected="selected"<% } %>>' +
                '<%- data.title %>' +
                '</option>'
        },

        /**
         *
         * @private
         */
        _create: function () {
            let self = this;
            this.regionList = $(this.options.regionListId);
            this.countryList = $('#country');
            this.defaultRegion = $(this.options.defaultRegion);
            this.cityElem = $(this.options.cityInputId);

            this.districtElem = $(this.options.districtInputId);
            this.districtList = $(this.options.districtListId);
            this.districtLabel = this.districtList.parents('div.field');
            this.defaultDistrictId = this.options.defaultDistrictId;

            this.wardElem = $(this.options.wardInputId);
            this.wardList = $(this.options.wardListId);
            this.defaultWardId = this.options.defaultWardId;
            this.wardLabel = this.wardList.parents('div.field');
            $('.country').hide();
            this.optionTmpl = mageTemplate(this.options.optionTemplate);
            this._initDistrictElement();
            this._initWardElement();

            self._updateDistrict(self.regionList.val());
            self._updateWard(self.defaultDistrictId);

        },

        _initDistrictElement: function () {
            this.regionList.on('change', $.proxy(function (e) {
                this._updateDistrict($(e.target).val());
                this.cityElem.val($(e.target).find('option:selected').text());
            }, this));

            this.countryList.on('change', $.proxy(function (e) {
                this._updateDistrict($(e.target).val());
            }, this));
            this.districtList.on('change', $.proxy(function (e) {
                this.districtElem.val($(e.target).find('option:selected').text());
            }, this));
        },

        _initWardElement: function () {
            this.regionList.on('change', $.proxy(function (e) {
                this._updateWard('');
                this.cityElem.val($(e.target).find('option:selected').text());
            }, this));

            this.districtList.on('change', $.proxy(function (e) {
                this._updateWard($(e.target).val());
            }, this));
            this.wardList.on('change', $.proxy(function (e) {
                this.wardElem.val($(e.target).find('option:selected').text());
            }, this));
        },

        /**
         * Remove options from dropdown list
         *
         * @param {Object} selectElement - jQuery object for dropdown list
         * @private
         */
        _removeSelectOptions: function (selectElement) {
            selectElement.find('option').each(function (index) {
                if (index) {
                    $(this).remove();
                }
            });
        },

        /**
         * Render dropdown list
         * @param {string} type of options
         * @param {Object} selectElement - jQuery object for dropdown list
         * @param {String} key - region code
         * @param {Object} value - region object
         * @private
         */
        _renderSelectOption: function (type, selectElement, key, value) {
            let isSelected = false;
            if (type === 'district') {
                isSelected = value.value === this.defaultDistrictId;
            }

            if (type === 'ward') {
                isSelected = value.value === this.defaultWardId;
            }

            let self = this;
            selectElement.append(function () {
                let name = value.label.replace(/[!"#$%&'()*+,.\/:;<=>?@[\\\]^`{|}~]/g, '\\$&'),
                    tmplData,
                    tmpl;

                if (value.value && $(name).is('span')) {
                    key = value.value;
                    value.label = $(name).text();
                }

                tmplData = {
                    value: value.value,
                    title: value.label,
                    isSelected: isSelected
                };

                tmpl = self.optionTmpl({
                    data: tmplData
                });

                return $(tmpl);
            });
        },

        _updateDistrict: function (region) {
            let self = this;
            this._clearError();
            $("#district_id option").each(function () {
                if ($(this).val() !== '') {
                    $(this).remove();
                }
            });

            if (region && this.options.districtJson[region] !== {} && this.options.districtJson[region] !== undefined) {
                $.each(this.options.districtJson[region], function (key, value) {
                    self._renderSelectOption('district', self.districtList, key, value);
                });
                self.districtList.addClass('required-entry');
                self.districtLabel.addClass('required');
            }
            this.districtElem.val($(this.districtList).find('option:selected').text())
        },

        _updateWard: function (district) {
            let self = this,
                currentDistrict = $(this.districtList).find('option:selected').val();
            if (district === '') {
                district = currentDistrict;
            }

            this._clearError();
            $("#ward_id option").each(function () {
                if ($(this).val() !== '') {
                    $(this).remove();
                }
            });

            if (district && this.options.wardJson[district] !== {} && this.options.wardJson[district] !== undefined) {
                $.each(this.options.wardJson[district], function (key, value) {
                    self._renderSelectOption('ward', self.wardList, key, value);
                });
                self.wardList.addClass('required-entry').removeAttr('disabled');
                self.wardLabel.addClass('required');
            }
            this.wardElem.val($(this.wardList).find('option:selected').text())
        },

        _clearError: function () {
            let args = ['clearError', this.options.regionListId, this.options.regionInputId, this.options.postcodeId];

            if (this.options.clearError && typeof this.options.clearError === 'function') {
                this.options.clearError.call(this);
            } else {
                if (!this.options.form) {
                    this.options.form = this.element.closest('form').length ? $(this.element.closest('form')[0]) : null;
                }

                this.options.form = $(this.options.form);

                this.options.form && this.options.form.data('validator') &&
                this.options.form.validation.apply(this.options.form, _.compact(args));

                // Clean up errors on region & zip fix
                $(this.options.regionInputId).removeClass('mage-error').parent().find('[generated]').remove();
                $(this.options.regionListId).removeClass('mage-error').parent().find('[generated]').remove();
                $(this.options.postcodeId).removeClass('mage-error').parent().find('[generated]').remove();
            }
        },
    });

    return $.mage.regionsManager;
});
