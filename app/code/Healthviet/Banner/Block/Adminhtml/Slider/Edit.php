<?php

namespace Healthviet\Banner\Block\Adminhtml\Slider;

use Magento\Backend\Block\Widget\Context;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry.
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * @param Context $context
     * @param array   $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;

        parent::__construct($context, $data);
    }
    protected function _construct()
    {
        $this->_objectId   = 'slider_id';
        $this->_blockGroup = 'Healthviet_Banner';
        $this->_controller = 'adminhtml_slider';

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save Slider'));
        $this->buttonList->update('delete', 'label', __('Delete'));

        if ($this->getSlider()->getId()) {
            $this->buttonList->add(
                'create_banner',
                [
                    'label'   => __('Create Banner'),
                    'class'   => 'add',
                    'onclick' => 'openBannerPopup(\''.$this->getCreateBannerUrl().'\')',
                ],
                1
            );
        }

        $this->_formScripts[] = "
			require(['jquery'], function($){
				window.openBannerPopup = function (url) {

                    var left = ($(document).width()-1000)/2, height= $(document).height(),

                        open_popup = window.open(url, '_blank','width=1000,resizable=1,scrollbars=1,toolbar=1,'+'left='
                            +left+',height='+height),

                        windowFocusHandle = function(){
                            if (open_popup.closed) {
                                if (typeof bannerGridJsObject !== 'undefined' && open_popup.id) {
                                    bannerGridJsObject.reloadParams['banner[]'].push(open_popup.id + '');
                                    $(edit_form.slider_banner).val($(edit_form.slider_banner).val() + '&'
                                    + open_popup.id + '=' + Base64.encode('sort_order =0'));
                                    bannerGridJsObject.setPage(open_popup.id);
                                }
                                $(window).off('focus', windowFocusHandle);
                            } else {
                                $(open_popup).trigger('focus');
                                open_popup.alert('" . __('You have to save the banner and close this window!') . "');
                            }
                        }

                        $(window).focus(windowFocusHandle);
                    }
			});
		";
    }

    public function getSlider()
    {
        return $this->coreRegistry->registry('slider');
    }

    /**
     * Retrieve the save and continue edit Url.
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl(
            '*/*/save',
            ['_current' => true, 'back' => 'edit', 'tab' => '{{tab_id}}']
        );
    }

    /**
     * get create banner url.
     *
     * @return string
     */
    public function getCreateBannerUrl()
    {
        return $this->getUrl('*/banner/new', ['current_slider_id' => $this->getSlider()->getId()]);
    }
}
