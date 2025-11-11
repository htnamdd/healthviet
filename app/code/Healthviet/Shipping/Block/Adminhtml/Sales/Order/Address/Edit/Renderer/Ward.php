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

class Ward extends AbstractBlock implements RendererInterface
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
        $country = $element->getForm()->getElement('country_id');
        $region = $element->getForm()->getElement('region_id');

        if (!$district = $element->getForm()->getElement('district_id')) {
            return $element->getDefaultHtml();
        }

        $ward = $this->getWardId();
        $ward = $ward ?: $element->getForm()->getElement('ward_id')->getValue();

        $html = '<div class="field field-ward required admin__field _required">';
        $element->setClass('input-text admin__control-text');
        $element->setRequired(true);
        $html .= $element->getLabelHtml() . '<div class="control admin__field-control">';
        $html .= $element->getElementHtml();

        $selectName = str_replace('ward', 'ward_id', $element->getName());
        $selectId = $element->getHtmlId() . '_id';

        $html .= '<select id="' .
            $selectId .
            '" name="' .
            $selectName .
            '" class="select required-entry admin__control-select" style="display:block;">';
        $html .= '<option value="">' . __('Please select a ward') . '</option>';
        $html .= '</select>';

        $html .= '<script>' . "\n";
        $html .= 'require(["prototype", "Healthviet_Shipping/js/form"], function(){';
        $html .= '$("' . $selectId . '").setAttribute("defaultValue", "' . $ward . '");' . "\n";
        $html .= 'new WardUpdater("' .
            $country->getHtmlId() .
            '", "' .
            $region->getHtmlId() .
            '", "' .
            $district->getHtmlId() .
            '", "' .
            $element->getHtmlId() .
            '", "' .
            $selectId .
            '", ' .
            $this->directoryHelper->getRegionJson() .
            ', ' .
            $this->customAttributes->getWardJson() .
            ');';

        $html .= '});';
        $html .= '</script>';

        $html .= '</div></div>';

        return $html;
    }
}
