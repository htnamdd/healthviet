<?php


namespace Healthviet\Banner\Block\Adminhtml\Slider\Edit\Tab;

class Form extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    const FIELD_NAME = 'slider';

    /**
     * @var \Magento\Config\Model\Config\Structure\Element\Dependency\FieldFactory
     */
    protected $fieldFactory;

    /**
     * [__construct description].
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param \Magento\Config\Model\Config\Structure\Element\Dependency\FieldFactory $fieldFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Config\Model\Config\Structure\Element\Dependency\FieldFactory $fieldFactory,
        array $data = []
    )
    {
        parent::__construct($context, $registry, $formFactory, $data);

        $this->fieldFactory = $fieldFactory;
    }

    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock('page.title')->setPageTitle($this->getPageTitle());
    }

    /**
     * Prepare form.
     *
     * @return \Healthviet\Banner\Block\Adminhtml\Slider\Edit\Tab\Form
     */
    protected function _prepareForm()
    {
        $slider = $this->getSlider();
        $isElementDisabled = true;
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        /*
         * declare dependence
         */
        $dependenceBlock = $this->getLayout()->createBlock(
            'Magento\Backend\Block\Widget\Form\Element\Dependence'
        );

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Slider Details')]);

        if ($slider->getId()) {
            $fieldset->addField('slider_id', 'hidden', ['name' => 'slider_id']);
        }

        $fieldset->addField(
            'slider_code',
            'text',
            [
                'name' => 'slider_code',
                'label' => __('Slider Code'),
                'title' => __('Slider Code'),
                'tooltip' => [
                    'description' => __('The unique code for each slider')
                ],
                'required' => true,
                'class' => 'required-entry'
            ]
        );

        $titleElement = $elements['title'] = $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Title'),
                'title' => __('Title'),
                'required' => true,
                'class' => 'required-entry'
            ]
        );


        $showTitleElement = $elements['show_title'] = $fieldset->addField(
            'show_title',
            'radios',
            [
                'name' => 'show_title',
                'label' => __('Show Slider Title'),
                'title' => __('Show Slider Title'),
                'required' => false,
                'values' => [
                    ['value' => 1, 'label' => __('Yes')],
                    ['value' => 0, 'label' => __('No')]
                ],
                'default' => 0
            ]
        );

        $fieldset->addField(
            'enable',
            'radios',
            [
                'name' => 'enable',
                'label' => __('Enable'),
                'title' => __('Enable'),
                'required' => false,
                'value' => 1,
                'values' => [
                    ['value' => 1, 'label' => __('Yes')],
                    ['value' => 0, 'label' => __('No')]
                ],
                'default' => 1
            ]
        );

        $form->setValues($slider->getData());
        $form->addFieldNameSuffix(self::FIELD_NAME);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    public function getSlider()
    {
        return $this->_coreRegistry->registry('slider');
    }

    public function getPageTitle()
    {
        return $this->getSlider()->getId()
            ? __("Edit Slider '%1'", $this->escapeHtml($this->getSlider()->getTitle()))
            : __('New Slider');
    }

    /**
     * Prepare label for tab.
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Slider Details');
    }

    /**
     * Prepare title for tab.
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Slider Details');
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     * @api
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     * @api
     */
    public function isHidden()
    {
        return false;
    }
}
