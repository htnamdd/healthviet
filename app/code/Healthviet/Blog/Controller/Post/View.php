<?php

namespace Healthviet\Blog\Controller\Post;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\ForwardFactory;
use \Magento\Framework\Registry;
use Healthviet\Blog\Model\PostFactory;
use Healthviet\Blog\Helper\Data;

class View extends \Magento\Framework\App\Action\Action
{
    protected $_resultPageFactory;
    protected $_postFactory;
    protected $_resultForwardFactory;
    protected $_registry;
    protected $_helper;
    protected $_url;

    public function __construct(
        Context        $context,
        PageFactory    $resultPageFactory,
        PostFactory    $postFactory,
        ForwardFactory $resultForwardFactory,
        Registry       $registry,
        Data           $helper
    )
    {
        $this->_helper = $helper;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_postFactory = $postFactory;
        $this->_resultForwardFactory = $resultForwardFactory;
        $this->_registry = $registry;

        parent::__construct($context);
    }

    public function execute()
    {
        //$postIdentifier = $this->getRequest()->getParam('post_identifier');
        $post = $this->_registry->registry('tm_blog_post');
        if (!$post->getId() || !$post->getIsVisible()) {
            $resultForward = $this->_resultForwardFactory->create();
            return $resultForward->forward('noroute');
        }
        $this->_registry->register('current_healthviet_blog_post', $post);
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->getConfig()->setPageLayout($this->_helper->getPostLayout());
        $resultPage->getConfig()->setDescription(strip_tags(trim($post->getShortContent(), '.') . '. Sử dụng thực phẩm chức năng Hàn Quốc để có được sức khỏe dẻo dai, ngăn ngừa đột quỵ'));
        $resultPage->getConfig()->setKeywords('Thức phẩm chức năng Hàn Quốc, An cung ngưu hoàng hoàn token, Bỗ não trầm hương, Giải độc gan, Bỗ Não Kwangdong, Cao hồng sâm, Cao hồng sâm đông trùng hạ thảo, Tinh dầu thông đỏ, Ổn định huyết áp, Mỡ máu');
        $resultPage->getConfig()->addRemotePageAsset(
            $this->_url->getCurrentUrl(),
            'canonical',
            ['attributes' => ['rel' => 'canonical']]
        );
        return $resultPage;
    }
}
