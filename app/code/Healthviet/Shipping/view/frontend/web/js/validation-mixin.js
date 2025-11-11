define([
    'underscore',
    'jquery',
    'Magento_Ui/js/lib/validation/utils'
], function (_, $, utils) {
    'use strict';

    return function (validator) {
        validator.addRule(
            'validate-exact-length',
            function (value, params) {
                return !_.isUndefined(value) && value.length === +params;
            },
            $.mage.__('Please enter exactly {0} characters.')
        );

        validator.addRule(
            'max_text_length',
            function (value, params) {
                return !_.isUndefined(value) && value !== null && value.length <= +params;
            },
            $.mage.__('Please enter less or equal than {0} symbols.')
        );

        validator.addRule(
            'validate-vietnamese-alphanumeric-with-spaces',
            function (value) {
                return utils.isEmptyNoTrim(value) || /^[a-zA-Z0-9àáãạảăắằẳẵặâấầẩẫậèéẹẻẽêềếểễệđìíĩỉịòóõọỏôốồổỗộơớờởỡợùúũụủưứừửữựỳỵỷỹýÀÁÃẠẢĂẮẰẲẴẶÂẤẦẨẪẬÈÉẸẺẼÊỀẾỂỄỆĐÌÍĨỈỊÒÓÕỌỎÔỐỒỔỖỘƠỚỜỞỠỢÙÚŨỤỦƯỨỪỬỮỰỲỴỶỸÝ\s]+$/.test(value);
            },
            $.mage.__('Please use only Vietnamese letters (a-z or A-Z), numbers (0-9) or spaces only in this field.')
        );

        return validator;
    };
});
