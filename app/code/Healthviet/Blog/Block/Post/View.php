<?php

namespace Healthviet\Blog\Block\Post;

use Healthviet\Blog\Helper\Data as HelperData;
use Healthviet\Blog\Model\Url;
use Magento\Cms\Model\Template\FilterProvider;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;

class View extends Template
{
    /**
     * @var Registry
     */
    protected $_registry;
    /**
     * @var
     */
    protected $_post;
    /**
     * @var Url
     */
    protected $_urlModel;

    /**
     * @var HelperData
     */
    protected $_helper;

    /**
     * @var FilterProvider
     */
    protected $_filterProvider;

    /**
     * @param Registry $registry
     * @param HelperData $helper
     * @param FilterProvider $filterProvider
     * @param Template\Context $context
     * @param Url $url
     * @param array $data
     */
    public function __construct(
        Registry         $registry,
        HelperData       $helper,
        FilterProvider   $filterProvider,
        Template\Context $context,
        Url              $url,
        array            $data = []
    ) {
        $this->_urlModel = $url;
        $this->_helper = $helper;
        $this->_registry = $registry;
        $this->_filterProvider = $filterProvider;
        parent::__construct($context, $data);
    }

    /**
     * @return View
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function _prepareLayout()
    {
        $post = $this->getPost();
        $this->_addBreadcrumbs($post);
        $this->pageConfig->addBodyClass('blog-post-' . $post->getIdentifier());
        $this->pageConfig->getTitle()->set($post->getTitle());
        $this->pageConfig->setKeywords($post->getMetaKeywords());
        $this->pageConfig->setDescription($post->getMetaDescription());

        return parent::_prepareLayout();
    }

    /**
     * @param $post
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function _addBreadcrumbs($post)
    {
        if ($this->_scopeConfig->getValue('web/default/show_cms_breadcrumbs', ScopeInterface::SCOPE_STORE)
            && ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs'))) {
            $breadcrumbsBlock->addCrumb(
                'home',
                [
                    'label' => __('Home'),
                    'title' => __('Go to Home Page'),
                    'link' => $this->_storeManager->getStore()->getBaseUrl()
                ]
            );
            $breadcrumbsBlock->addCrumb(
                'tm_blog',
                [
                    'label' => __($this->_helper->getTitle()),
                    'title' => __($this->_helper->getTitle()),
                    'link' => $this->getUrl($this->_helper->getRoute())
                ]
            );
            if ($category = $post->getOneCategory()) {
                if ($category->getId()) {
                    $breadcrumbsBlock->addCrumb(
                        'tm_category',
                        [
                            'label' => __($category->getName()),
                            'title' => __($category->getName())
                            //'link' => $this->getUrl($this->_helper->getRoute())
                        ]
                    );
                }
            }
            $breadcrumbsBlock->addCrumb(
                'tm_blog_post',
                [
                    'label' => __($post->getTitle()),
                    'title' => __($post->getTitle())
                ]
            );
        }
    }

    /**
     * @return mixed|null
     */
    public function getPost()
    {
        if (!$this->_post) {
            $this->_post = $this->_registry->registry('tm_blog_post');
        }
        return $this->_post;
    }

    /**
     * @param $data
     * @return string
     * @throws \Exception
     */
    public function filterContent($data)
    {
        return $this->_filterProvider->getBlockFilter()->filter($data);
    }

    /**
     * @return mixed
     */
    public function getDateFormat()
    {
        return $this->_helper->getDataFormat();
    }

    /**
     * @return string
     */
    public function getPostRoute()
    {
        return 'https://healthviet.com.vn/' . $this->_urlModel->getPostRoute($this->_post);
    }
}
