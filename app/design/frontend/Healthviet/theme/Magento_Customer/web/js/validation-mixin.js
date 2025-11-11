define(['jquery'], function($) {
    'use strict';

    return function() {
        var rules = {
            'validate-length': [
                function (v, elm) {
                    var reMax = new RegExp(/^maximum-length-[0-9]+$/),
                        reMin = new RegExp(/^minimum-length-[0-9]+$/),
                        reExact = new RegExp(/^exact-length-[0-9]+$/),
                        validator = this,
                        result = true,
                        length = 0;

                    $.each(elm.className.split(' '), function (index, name) {
                        if (name.match(reMax) && result) {
                            length = name.split('-')[2];
                            result = v.length <= length;
                            validator.validateMessage =
                                $.mage.__('Please enter less or equal than %1 symbols.').replace('%1', length);
                        }

                        if (name.match(reMin) && result && !$.mage.isEmpty(v)) {
                            length = name.split('-')[2];
                            result = v.length >= length;
                            validator.validateMessage =
                                $.mage.__('Please enter more or equal than %1 symbols.').replace('%1', length);
                        }

                        if (name.match(reExact) && result && !$.mage.isEmpty(v)) {
                            length = parseInt(name.split('-')[2]);
                            result = v.length === length;
                            validator.validateMessage =
                                $.mage.__('Please enter exactly %1 characters.').replace('%1', length);
                        }
                    });

                    return result;
                }, function () {
                    return this.validateMessage;
                }
            ]
        };

        $.each(rules, function (i, rule) {
            rule.unshift(i);
            $.validator.addMethod.apply($.validator, rule);
        });
    }
});
