<?php
namespace Healthviet\Customer\Plugin\Magento\Eav\Model\Attribute\Data;

use Magento\Eav\Model\Attribute\Data\Text as Subject;

class Text
{
    public function afterValidateValue(Subject $subject, $result, $value)
    {
        $attribute = $subject->getAttribute();
        $validateRules = $attribute->getValidateRules();
        if (!empty($validateRules['input_validation'])
            && $validateRules['input_validation'] == 'vietnamese-alphanumeric-with-spaces') {
            if (preg_match(
                '/[^a-zA-Z0-9àáãạảăắằẳẵặâấầẩẫậèéẹẻẽêềếểễệđìíĩỉịòóõọỏôốồổỗộơớờởỡợùúũụủưứừửữựỳỵỷỹýÀÁÃẠẢĂẮẰẲẴẶÂẤẦẨẪẬÈÉẸẺẼÊỀẾỂỄỆĐÌÍĨỈỊÒÓÕỌỎÔỐỒỔỖỘƠỚỜỞỠỢÙÚŨỤỦƯỨỪỬỮỰỲỴỶỸÝ ]/',
                $value
            )) {
                $label = $attribute->getStoreLabel();
                $message = __('Please use only Vietnamese letters (a-z or A-Z), numbers (0-9) or spaces only in "%1" field.', $label);
                if (is_bool($result)) {
                    return [$message];
                } else {
                    $result[] = __($message);
                }
            }
        }

        return $result;
    }
}
