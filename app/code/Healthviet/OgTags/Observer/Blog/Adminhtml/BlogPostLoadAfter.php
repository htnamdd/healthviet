<?php

namespace Healthviet\OgTags\Observer\Blog\Adminhtml;

use Magento\Framework\Event\ObserverInterface;
use Healthviet\OgTags\Model\Blog\PostFactory as OgFactory;
use Magefan\OgTags\Observer\AbstractLoadAfter;

/**
 * Class BlogPostLoadAfter
 * @package Healthviet\OgTags\Observer\Blog\Adminhtml
 */
class BlogPostLoadAfter extends AbstractLoadAfter implements ObserverInterface
{
    /**
     * CmsPageLoadAfter constructor.
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param OgFactory $ogFactory
     * @param string $field
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface  $storeManager,
        OgFactory $ogFactory,
        $field = 'post_id'
    ) {
        parent::__construct($storeManager, $ogFactory, $field);
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->load($observer->getDataObject());
    }
}
