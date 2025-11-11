define([
    'jquery',
    'matchMedia'
], function ($, mediaCheck) {
    'use strict';

    $(document).ready(function() {
        var stickyTop = $('.product-title-sticky').offset().top;

        $(window).scroll(function() {
            var windowTop = $(window).scrollTop();
            if (stickyTop < windowTop) {
                $('.catalog-product-view').addClass('sticky');
            } else {
                $('.catalog-product-view').removeClass('sticky');
            }
        });
    });
});
