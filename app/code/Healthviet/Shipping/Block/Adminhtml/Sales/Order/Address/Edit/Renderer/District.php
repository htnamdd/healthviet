<?php

declare(strict_types=1);

namespace Healthviet\Shipping\Block\Adminhtml\Sales\Order\Address\Edit\Renderer;

use Magento\Backend\Block\AbstractBlock;
use Magento\Backend\Block\Context;
use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Healthviet\Customer\ViewModel\Address\CustomAttributes;

class District extends AbstractBlock implements RendererInterface
{
    /**
     * @var DirectoryHelper
     */
    protected $directoryHelper;

    /**
     * @var CustomAttributes
     */
    protected $customAttributes;

    /**
     * @param DirectoryHelper $directoryHelper
     * @param CustomAttributes $customAttributes
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        DirectoryHelper $directoryHelper,
        CustomAttributes $customAttributes,
        Context $context,
        array $data = []
    ) {
        $this->directoryHelper = $directoryHelper;
        $this->customAttributes = $customAttributes;
        parent::__construct($context, $data);
    }

    /**
     * @param AbstractElement $element
     * @return string
     * @throws NoSuchEntityException
     */
    public function render(AbstractElement $element): string
    {
        if (!$region = $element->getForm()->getElement('region_id')) {
            return $element->getDefaultHtml();
        }

        if (!$country = $element->getForm()->getElement('country_id')) {
            return $element->getDefaultHtml();
        }

        $city = $element->getForm()->getElement('city');
        $regionText = $element->getForm()->getElement('region');

        $districtId = $this->getDistrictId();

        $html = '<div class="field field-district required admin__field _required">';
        $element->setClass('input-text admin__control-text');
        $element->setRequired(true);
        $html .= $element->getLabelHtml() . '<div class="control admin__field-control">';
        $html .= $element->getElementHtml();

        $selectName = str_replace('district', 'district_id', $element->getName());
        $selectId = $element->getHtmlId() . '_id';
        $html .= '<select id="' .
            $selectId .
            '" name="' .
            $selectName .
            '" class="select required-entry admin__control-select" style="display:block;">';
        $html .= '<option value="">' . __('Please select a district') . '</option>';
        $html .= '</select>';

        $html .= '<script>' . "\n";
        $html .= 'require(["prototype", "Healthviet_Shipping/js/form"], function(){';
        $html .= '$("' . $selectId . '").setAttribute("defaultValue", "' . $districtId . '");' . "\n";
        $html .= 'new DistrictUpdater("' .
            $country->getHtmlId() .
            '", "' .
            $region->getHtmlId() .
            '", "' .
            $regionText->getHtmlId() .
            '", "' .
            $city->getHtmlId() .
            '", "' .
            $element->getHtmlId() .
            '", "' .
            $selectId .
            '", ' .
            $this->customAttributes->getDistrictJson() .
            ', ' .
            $this->directoryHelper->getRegionJson() .
            ');';

        $html .= '});';
        $html .= '</script>';

        $html .= '</div></div>';

        return $html;
    }
}
