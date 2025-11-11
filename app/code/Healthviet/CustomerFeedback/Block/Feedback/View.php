<?php

namespace Healthviet\CustomerFeedback\Block\Feedback;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;

class View extends Template
{
    /**
     * @var Registry
     */
    protected $_registry;

    protected $_feedback;

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
        $feedback = $this->getFeedback();
        $this->_addBreadcrumbs($feedback);
        $this->pageConfig->addBodyClass('feedback-' . $feedback->getIdentifier());
        $this->pageConfig->getTitle()->set($feedback->getName());
        $this->pageConfig->setKeywords($feedback->getMetaKeywords());
        $this->pageConfig->setDescription($feedback->getMetaDescription());

        return parent::_prepareLayout();
    }

    protected function _addBreadcrumbs($feedback)
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
                    'label' => __('Feedback'),
                    'title' => __('Feedback'),
                    'link' => '../trai-nghiem-khach-hang.html'
                ]
            );
            $breadcrumbsBlock->addCrumb(
                'healthviet_feedback',
                [
                    'label' => __($feedback->getName()),
                    'title' => __($feedback->getName())
                ]
            );
        }
    }

    public function getFeedback()
    {
        if (!$this->_feedback) {
            $this->_feedback = $this->_registry->registry('healthviet_feedback_feedback');
            $path = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
            $this->_feedback->setAvatar($path . $this->_feedback->getAvatar());
        }
        return $this->_feedback;
    }
}
