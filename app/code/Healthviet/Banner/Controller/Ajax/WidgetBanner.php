<?php

namespace Healthviet\Banner\Controller\Ajax;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;

class WidgetBanner extends \Magento\Framework\App\Action\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;
    /**
     * @var \Magento\Framework\App\CacheInterface
     */
    protected $cache;
    protected $dataHelper;

    /**
     * View constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory,
        \Magento\Framework\App\CacheInterface $cache,
        \Healthviet\Common\Helper\Data $dataHelper
    ) {

        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->cache = $cache;
        $this->dataHelper = $dataHelper;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $params = $this->getRequest()->getParams();

        $resultPage = $this->resultPageFactory->create();
        $blockHtml = $resultPage->getLayout()
            ->createBlock('Healthviet\Banner\Block\Banner')
            ->setData($params)
            ->toHtml();

        $result->setData(
            [
                'html' => $blockHtml,
                'cached' => false
            ]
        );
        return $result;
    }
}
