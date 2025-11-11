define([
    "jquery",
    "slick"
], function ($) {
    "use strict";
    $.widget('healthvietBanner.ajax', {
        options: {
            sectionId: '',
            params: ''
        },
        _create: function () {
            var self = this;
            self._ajaxSubmit(self.options);
            $(window).scroll(function () {
                self._ajaxSubmit(self.options);
            });

        },

        _ajaxSubmit: function (options) {
            var self = this;
            var wt = $(window).scrollTop();
            var wb = wt + $(window).height();
            var section = $('#' + options.sectionId);
            var ot = section.offset().top;
            var ob = ot + section.height();
            if (!section.attr("loaded") && wt <= ob && wb >= ot) {
                $.ajax({
                    type: 'GET',
                    url: options.params.baseUrl + 'healthviet_banner/ajax/widgetbanner',
                    dataType: 'json',
                    data: options.params,
                    beforeSend: function () {
                        section.addClass('ajax-loading');
                    },
                    success: function (res) {
                        section.html(res.html);
                        section.removeClass('ajax-loading');
                    }
                });
                section.attr("loaded", true);
            }
        },


    });

    return $.healthvietBanner.ajax;
});
