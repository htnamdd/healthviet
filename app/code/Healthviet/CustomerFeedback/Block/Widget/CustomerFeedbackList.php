<?php

namespace Healthviet\CustomerFeedback\Block\Widget;

use Healthviet\CustomerFeedback\Model\ResourceModel\CustomerFeedback\CollectionFactory;
use Magento\Catalog\Block\Product\Widget\Html\Pager;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;

class CustomerFeedbackList extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    /**
     * Default value for how many feedbacks should be displayed
     */
    const DEFAULT_FEEDBACKS_COUNT = 10;

    /**
     * Default value for feedbacks per page
     */
    const DEFAULT_FEEDBACKS_PER_PAGE = 3;

    /**
     * Default value whether show pager or not
     */
    const DEFAULT_SHOW_PAGER = false;

    /**
     * Instance of pager block
     *
     * @var Pager
     */
    protected $pager;

    protected $_template = 'widget/customer_feedback_list.phtml';
    private CollectionFactory $collectionFactory;

    public function __construct(
        Template\Context  $context,
        CollectionFactory $collectionFactory,
        array             $data = []
    )
    {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
    }

    public function getFeedbacks()
    {
        $collection = $this->collectionFactory->create()
            ->addFieldToFilter('enable', 1)
            ->setPageSize($this->getPageSize())
            ->setCurPage($this->getRequest()->getParam($this->getData('page_var_name'), 1))
            ->addOrder('updated_at');
        $path = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        foreach ($collection as $item) {
            if ($item->getAvatar()) {
                $item->setAvatar($path . $item->getAvatar());
            }
            $item->setIdentifier('/feedback/' . $item->getIdentifier());
        }

        return $collection;
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function toHtml()
    {
        return $this->getWidgetStatus() ? parent::toHtml() : '';
    }

    /**
     * @inheritdoc
     */
    protected function _beforeToHtml()
    {
        $this->setFeedbackCollection($this->getFeedbacks());
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve how many feedbacks should be displayed
     *
     * @return int
     */
    public function getFeedbacksCount(): int
    {
        if ($this->hasData('feedback_amount')) {
            return $this->getData('feedback_amount');
        }

        if (null === $this->getData('feedback_amount')) {
            $this->setData('feedback_amount', self::DEFAULT_FEEDBACKS_COUNT);
        }

        return $this->getData('feedback_amount');
    }

    /**
     * Retrieve how many feedbacks should be displayed
     *
     * @return int
     */
    public function getCustomerFeedbacksPerPage(): int
    {
        if (!$this->hasData('feedbacks_per_page')) {
            $this->setData('feedbacks_per_page', self::DEFAULT_FEEDBACKS_PER_PAGE);
        }
        return $this->getData('feedbacks_per_page');
    }

    /**
     * Return flag whether pager need to be shown or not
     *
     * @return bool
     */
    public function showPager(): bool
    {
        if (!$this->hasData('show_pager')) {
            $this->setData('show_pager', self::DEFAULT_SHOW_PAGER);
        }
        return (bool)$this->getData('show_pager');
    }

    /**
     * Retrieve how many feedbacks should be displayed on page
     *
     * @return int
     */
    protected function getPageSize(): int
    {
        return $this->showPager() ? $this->getCustomerFeedbacksPerPage() : $this->getFeedbacksCount();
    }

    /**
     * Render pagination HTML
     *
     * @return string
     * @throws LocalizedException
     */
    public function getPagerHtml(): string
    {
        if ($this->showPager() && $this->getFeedbackCollection()->getSize() > $this->getCustomerFeedbacksPerPage()) {
            if (!$this->pager) {
                $this->pager = $this->getLayout()->createBlock(
                    Pager::class,
                    $this->getWidgetPagerBlockName()
                );

                $this->pager->setUseContainer(true)
                    ->setShowAmounts(true)
                    ->setShowPerPage(false)
                    ->setPageVarName($this->getData('page_var_name'))
                    ->setLimit($this->getCustomerFeedbacksPerPage())
                    ->setTotalLimit($this->getFeedbacksCount())
                    ->setCollection($this->getFeedbackCollection());
            }
            if ($this->pager instanceof \Magento\Framework\View\Element\AbstractBlock) {
                return $this->pager->toHtml();
            }
        }
        return '';
    }

    /**
     * Get widget block name
     *
     * @return string
     */
    private function getWidgetPagerBlockName(): string
    {
        $pageName = $this->getData('page_var_name');
        $pagerBlockName = 'widget.feedbacks.list.pager';

        if (!$pageName) {
            return $pagerBlockName;
        }

        return $pagerBlockName . '.' . $pageName;
    }
}
