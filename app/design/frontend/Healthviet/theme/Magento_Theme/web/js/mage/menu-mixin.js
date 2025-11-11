define(['jquery'], function ($) {
    'use strict';

    var menuMixin = {
        _init: function () {
            this._super();
            // fix bug expand on mobile
            this._toggleDesktopMode();

            if (this.options.expanded === true) {
                this.isExpanded();
            }

            if (this.options.responsive === true) {
                mediaCheck({
                    media: this.options.mediaBreakpoint,
                    entry: $.proxy(function () {
                        this._toggleMobileMode();
                    }, this),
                    exit: $.proxy(function () {
                        this._toggleDesktopMode();
                    }, this)
                });
            }

            this._assignControls()._listen();
            this._setActiveMenu();
        },
    };

    return function (targetWidget) {
        // Example how to extend a widget by mixin object
        $.widget('mage.menu', targetWidget.menu, menuMixin);
        return $.mage.menu;
    };
});
