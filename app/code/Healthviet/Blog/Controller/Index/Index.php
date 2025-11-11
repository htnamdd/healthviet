<?php

namespace Healthviet\Blog\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use \Magento\Framework\Registry;
use Healthviet\Blog\Helper\Data as HelperData;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $resultPageFactory;
    protected $_helper;
    protected $_registry;

    public function __construct(
        Context     $context,
        PageFactory $resultPageFactory,
        Registry    $registry,
        HelperData  $helper
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->_helper = $helper;
        $this->_registry = $registry;

        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->setPageLayout($this->_helper->getPostListLayout());

        //Set Page title
        if ($category = $this->_registry->registry('tm_blog_category')) {
            $resultPage->getConfig()->getTitle()->set(__($category->getName()));
        } else {
            $pageTitle = $this->_helper->getMetaTitle();
            $resultPage->getConfig()->getTitle()->set(__($pageTitle));
            $resultPage->getConfig()->setDescription(__($this->_helper->getMetaDescription()));
            $resultPage->getConfig()->setKeywords(__($this->_helper->getMetaKeywords()));
        }
        $resultPage->getConfig()->addRemotePageAsset($this->_url->getCurrentUrl(),
            'canonical',
            ['attributes' => ['rel' => 'canonical']]);

        return $resultPage;
    }
}
