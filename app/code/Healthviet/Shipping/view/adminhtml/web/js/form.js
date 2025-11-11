define([
    "jquery",
    "prototype",
    "mage/adminhtml/events",
    'domReady!'
], function (jQuery) {
    window.DistrictUpdater = Class.create();
    DistrictUpdater.prototype = {
        initialize: function (countryEl, regionEl, regionTextElm, cityElm, districtTextEl, districtSelectEl,
                              districts, regions, disableAction, clearRegionValueOnDisable) {
            this.isDistrictRequired = true;
            this.countryEl = $(countryEl);
            this.regionEl = $(regionEl);
            this.regionTextEl = $(regionTextElm);
            this.cityEl = $(cityElm);
            this.districtTextEl = $(districtTextEl);
            this.districtSelectEl = $(districtSelectEl);
            this.config = districts['config'];
            delete districts.config;
            this.districts = districts;
            this.regions = regions;
            this.disableAction = (typeof disableAction == 'undefined') ? 'hide' : disableAction;
            this.clearRegionValueOnDisable = (typeof clearRegionValueOnDisable == 'undefined') ? false : clearRegionValueOnDisable;

            if (this.districtSelectEl.options.length <= 1) {
                this.districtTextEl = $(districtTextEl);
                this.update();
            } else {
                this.lastRegionId = this.regionEl.value;
            }

            // this.districtTextEl.hide();
            this.regionEl.changeUpdater = this.update.bind(this);
            Event.observe(this.countryEl, 'change', this.update.bind(this));
            Event.observe(this.regionEl, 'change', this.update.bind(this));
            Event.observe(this.districtSelectEl, 'change', this.syncvalue.bind(this));
        },
        syncvalue: function () {
            this.districtTextEl.value = this.districtSelectEl[this.districtSelectEl.selectedIndex].text
        },
        _checkDistrictRequired: function () {
            if (!this.isDistrictRequired) {
                return;
            }

            var elements = [this.districtTextEl, this.districtSelectEl];

            elements.each(function (currentElement) {
                if (!currentElement) {
                    return;
                }
                var form = currentElement.form,
                    validationInstance = form ? jQuery(form).data('validation') : null,
                    field = currentElement.up('.field') || new Element('div');

                if (validationInstance) {
                    validationInstance.clearError(currentElement);
                }

                //compute the need for the required fields
                if (!currentElement.visible()) {
                    if (field.hasClassName('required')) {
                        field.removeClassName('required');
                    }
                    if (currentElement.hasClassName('required-entry')) {
                        currentElement.removeClassName('required-entry');
                    }
                    if ('select' == currentElement.tagName.toLowerCase() &&
                        currentElement.hasClassName('validate-select')
                    ) {
                        currentElement.removeClassName('validate-select');
                    }
                } else {
                    if (!field.hasClassName('required')) {
                        field.addClassName('required');
                    }
                    if (!currentElement.hasClassName('required-entry')) {
                        currentElement.addClassName('required-entry');
                    }
                    if ('select' == currentElement.tagName.toLowerCase() &&
                        !currentElement.hasClassName('validate-select')
                    ) {
                        currentElement.addClassName('validate-select');
                    }
                }
            });
        },

        disableRegionValidation: function () {
            this.isDistrictRequired = false;
        },

        update: function () {
            if (this.districts[this.regionEl.value] && this.regions[this.countryEl.value]) {
                if (this.lastRegionId != this.regionEl.value) {
                    this.cityEl.value = this.regionEl.options[this.regionEl.selectedIndex].text;
                    this.regionTextEl.value = this.regionEl.options[this.regionEl.selectedIndex].text;
                    var option, def;

                    def = this.districtSelectEl.getAttribute('defaultValue');

                    if (this.districtTextEl) {
                        if (!def) {
                            def = this.districtTextEl.value.toLowerCase();
                        }
                        this.districtTextEl.value = '';
                    }

                    this.districtSelectEl.options.length = 1;
                    for (districtId in this.districts[this.regionEl.value]) {
                        district = this.districts[this.regionEl.value][districtId];
                        if (district['value']) {
                            option = document.createElement('OPTION');
                            option.value = district['value'];
                            option.text = district['label'];
                            option.title = district['value'];


                            if (this.districtSelectEl.options.add) {
                                this.districtSelectEl.options.add(option);
                            } else {
                                this.districtSelectEl.appendChild(option);
                            }

                            if (districtId === def || district['label'] === def || district['label'].toLowerCase() === def) {
                                this.districtSelectEl.value = districtId;
                                this.districtTextEl.value = district['label'];
                            }
                        }
                    }
                }

                if (this.disableAction == 'hide') {
                    if (this.districtTextEl) {
                        this.districtTextEl.style.display = 'none';
                        this.districtTextEl.style.disabled = true;
                    }
                    this.districtSelectEl.style.display = '';
                    this.districtSelectEl.disabled = false;
                } else if (this.disableAction == 'disable') {
                    if (this.districtTextEl) {
                        this.districtTextEl.disabled = true;
                    }
                    this.districtSelectEl.disabled = false;
                }
                this.setMarkDisplay(this.districtSelectEl, true);

                this.lastRegionId = this.regionEl.value;
            } else {
                this.districtSelectEl.value = '';
                if (this.disableAction == 'hide') {
                    if (this.districtTextEl) {
                        this.districtTextEl.style.display = '';
                        this.districtTextEl.style.disabled = false;
                    }
                    this.districtSelectEl.style.display = 'none';
                    this.districtSelectEl.disabled = true;
                } else if (this.disableAction == 'disable') {
                    if (this.districtTextEl) {
                        this.districtTextEl.disabled = false;
                    }
                    this.districtSelectEl.disabled = true;
                    if (this.clearRegionValueOnDisable) {
                        this.districtSelectEl.value = '';
                    }
                } else if (this.disableAction == 'nullify') {
                    this.districtSelectEl.options.length = 1;
                    this.districtSelectEl.value = '';
                    this.districtSelectEl.selectedIndex = 0;
                    this.lastRegionId = '';
                }
                this.setMarkDisplay(this.districtSelectEl, false);

            }
            if (typeof this.districtSelectEl.changeUpdater !== 'undefined') {
                this.districtSelectEl.changeUpdater();
            }
            this._checkDistrictRequired();
        },

        setMarkDisplay: function (elem, display) {
            if (elem.parentNode.parentNode) {
                var marks = Element.select(elem.parentNode.parentNode, '.required');
                if (marks[0]) {
                    display ? marks[0].show() : marks[0].hide();
                }
            }
        }
    };
    window.districtUpdater = DistrictUpdater;


    window.WardUpdater = Class.create();
    WardUpdater.prototype = {
        initialize: function (countryEl, regionEl, districtEl, wardTextEl, wardSelectEl, regions, wards, disableAction, clearRegionValueOnDisable) {
            this.isWardRequired = true;
            this.countryEl = $(countryEl);
            this.regionEl = $(regionEl);
            this.districtEl = $(districtEl);
            this.wardTextEl = $(wardTextEl);
            this.wardSelectEl = $(wardSelectEl);
            this.regions = regions;
            this.wards = wards;
            this.disableAction = (typeof disableAction == 'undefined') ? 'hide' : disableAction;
            this.clearRegionValueOnDisable = (typeof clearRegionValueOnDisable == 'undefined') ? false : clearRegionValueOnDisable;

            if (this.wardSelectEl.options.length <= 1) {
                this.update();
            } else {
                this.lastDistrictId = this.districtEl.value;
            }
            // this.wardTextEl.hide();
            this.districtEl.changeUpdater = this.update.bind(this);
            // this.regionEl.changeUpdater = this.update.bind(this);
            Event.observe(this.wardSelectEl, 'change', this.syncvalue.bind(this));
            Event.observe(this.districtEl, 'change', this.update.bind(this));
            Event.observe(this.countryEl, 'change', this.update.bind(this));
            Event.observe(this.regionEl, 'change', this.update.bind(this));
        },
        syncvalue: function () {
            ward = this.wards[this.districtEl.value][this.wardSelectEl.value];
            this.wardTextEl.value = this.wardSelectEl[this.wardSelectEl.selectedIndex].text;
        },
        _checkWardRequired: function () {
            if (!this.isWardRequired) {
                return;
            }

            var elements = [this.wardTextEl, this.wardSelectEl];

            elements.each(function (currentElement) {
                if (!currentElement) {
                    return;
                }
                var form = currentElement.form,
                    validationInstance = form ? jQuery(form).data('validation') : null,
                    field = currentElement.up('.field') || new Element('div');

                if (validationInstance) {
                    validationInstance.clearError(currentElement);
                }

                //compute the need for the required fields
                if (!currentElement.visible()) {
                    if (field.hasClassName('required')) {
                        field.removeClassName('required');
                    }
                    if (currentElement.hasClassName('required-entry')) {
                        currentElement.removeClassName('required-entry');
                    }
                    if ('select' == currentElement.tagName.toLowerCase() &&
                        currentElement.hasClassName('validate-select')
                    ) {
                        currentElement.removeClassName('validate-select');
                    }
                } else {
                    if (!field.hasClassName('required')) {
                        field.addClassName('required');
                    }
                    if (!currentElement.hasClassName('required-entry')) {
                        currentElement.addClassName('required-entry');
                    }
                    if ('select' == currentElement.tagName.toLowerCase() &&
                        !currentElement.hasClassName('validate-select')
                    ) {
                        currentElement.addClassName('validate-select');
                    }
                }
            });
        },

        disableRegionValidation: function () {
            this.isWardRequired = false;
        },

        update: function () {

            // if (this.districts[this.regionEl.value] && this.regions[this.countryEl.value]) {
            //     if (this.lastRegionId != this.regionEl.value) {
            if (typeof this.districtEl.value !== 'undefined' && this.wards[this.districtEl.value]) {
                if (this.lastDistrictId != this.districtEl.value) {
                    var i, option, region, def;

                    def = this.wardSelectEl.getAttribute('defaultValue');
                    if (this.wardTextEl) {
                        if (!def) {
                            def = this.wardTextEl.value.toLowerCase();
                        }
                        this.wardTextEl.value = '';
                    }

                    this.wardSelectEl.options.length = 1;
                    for (wardId in this.wards[this.districtEl.value]) {
                        ward = this.wards[this.districtEl.value][wardId];

                        if (ward['value']) {
                            option = document.createElement('OPTION');
                            option.value = ward['value'];
                            option.text = ward['label'];
                            option.title = ward['value'];



                            if (this.wardSelectEl.options.add) {
                                this.wardSelectEl.options.add(option);
                            } else {
                                this.wardSelectEl.appendChild(option);
                            }

                            if (wardId === def || ward['label'] === def || ward['label'].toLowerCase() === def) {
                                this.wardSelectEl.value = ward['value'];
                                this.wardTextEl.value = ward['label'];
                            }
                        }
                    }
                }

                if (this.disableAction == 'hide') {
                    if (this.wardTextEl) {
                        this.wardTextEl.style.display = 'none';
                        this.wardTextEl.style.disabled = true;
                    }
                    this.wardSelectEl.style.display = '';
                    this.wardSelectEl.disabled = false;
                } else if (this.disableAction == 'disable') {
                    if (this.wardTextEl) {
                        this.wardTextEl.disabled = true;
                    }
                    this.wardSelectEl.disabled = false;
                }
                this.setMarkDisplay(this.wardSelectEl, true);

                this.lastDistrictId = this.districtEl.value;
            } else {
                this.wardSelectEl.value = '';
                if (this.disableAction == 'hide') {
                    if (this.wardTextEl) {
                        this.wardTextEl.style.display = '';
                        this.wardTextEl.style.disabled = false;
                    }
                    this.wardSelectEl.style.display = 'none';
                    this.wardSelectEl.disabled = true;
                } else if (this.disableAction == 'disable') {
                    if (this.wardTextEl) {
                        this.wardTextEl.disabled = false;
                    }
                    this.wardSelectEl.disabled = true;
                    if (this.clearRegionValueOnDisable) {
                        this.wardSelectEl.value = '';
                    }
                } else if (this.disableAction == 'nullify') {
                    this.wardSelectEl.options.length = 1;
                    this.wardSelectEl.value = '';
                    this.wardSelectEl.selectedIndex = 0;
                    this.lastDistrictId = '';
                }
                this.setMarkDisplay(this.wardSelectEl, false);

            }
            if (typeof this.wardSelectEl.changeUpdater !== 'undefined') {
                this.wardSelectEl.changeUpdater();
            }
            this._checkWardRequired();
        },

        setMarkDisplay: function (elem, display) {
            if (elem.parentNode.parentNode) {
                var marks = Element.select(elem.parentNode.parentNode, '.required');
                if (marks[0]) {
                    display ? marks[0].show() : marks[0].hide();
                }
            }
        }
    };
    window.wardUpdater = WardUpdater;
});
