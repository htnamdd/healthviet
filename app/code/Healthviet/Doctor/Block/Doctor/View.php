<?php

namespace Healthviet\Doctor\Block\Doctor;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;

class View extends Template
{
    /**
     * @var Registry
     */
    protected $_registry;

    protected $_doctor;

    public function __construct(
        Registry $registry,
        Template\Context $context,
        array $data = []
    ) {
        $this->_registry = $registry;
        parent::__construct($context, $data);
    }

    protected function _prepareLayout()
    {
        $doctor = $this->getDoctor();
        $this->_addBreadcrumbs($doctor);
        $this->pageConfig->addBodyClass('doctor-' . $doctor->getIdentifier());
        $this->pageConfig->getTitle()->set($doctor->getName());
        $this->pageConfig->setKeywords($doctor->getMetaKeywords());
        $this->pageConfig->setDescription($doctor->getMetaDescription());

        return parent::_prepareLayout();
    }

    protected function _addBreadcrumbs($doctor)
    {
        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbsBlock->addCrumb(
                'home',
                [
                    'label' => __('Home'),
                    'title' => __('Go to Home Page'),
                    'link' => $this->_storeManager->getStore()->getBaseUrl()
                ]
            );
            $breadcrumbsBlock->addCrumb(
                'healthviet',
                [
                    'label' => __('Doctor'),
                    'title' => __('Doctor'),
                    'link' => '../chuyen-gia-danh-gia.html'
                ]
            );
            $breadcrumbsBlock->addCrumb(
                'healthviet_doctor',
                [
                    'label' => __($doctor->getName()),
                    'title' => __($doctor->getName())
                ]
            );
        }
    }

    public function getDoctor()
    {
        if (!$this->_doctor) {
            $this->_doctor = $this->_registry->registry('healthviet_doctor_doctor');

            $path = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
            $this->_doctor->setAvatar($path . $this->_doctor->getAvatar());
        }
        return $this->_doctor;
    }
}
