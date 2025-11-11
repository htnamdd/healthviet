<?php
namespace Healthviet\Customer\Plugin\Magento\Customer\Model;

use Magento\Customer\Api\Data\AttributeMetadataInterface;
use Magento\Customer\Model\Attribute;
use Magento\Customer\Model\AttributeMetadataConverter as Subject;

class AttributeMetadataConverter
{
    /**
     * @param Subject $subject
     * @param AttributeMetadataInterface $result
     * @param Attribute $attribute
     * @return AttributeMetadataInterface
     */
    public function afterCreateMetadataAttribute(
        Subject $subject,
        AttributeMetadataInterface $result,
        Attribute $attribute
    ): AttributeMetadataInterface {
        $classes = explode(' ', $result->getFrontendClass());
        $validateRules = $attribute->getValidateRules();
        if (!empty($validateRules['input_validation'])
            && $validateRules['input_validation'] == 'vietnamese-alphanumeric-with-spaces') {
            $classes[] = 'validate-vietnamese-alphanumeric-with-spaces';

            if (!empty($validateRules['min_text_length'])) {
                $classes[] = 'minimum-length-' . $validateRules['min_text_length'];
            }
            if (!empty($validateRules['max_text_length'])) {
                $classes[] = 'maximum-length-' . $validateRules['max_text_length'];
            }
            if (!empty($validateRules['min_text_length']) && !empty($validateRules['max_text_length'])) {
                $classes[] = 'validate-length';
            }
        }

        $result->setFrontendClass(implode(' ', array_unique(array_filter($classes))));
        return $result;
    }
}
