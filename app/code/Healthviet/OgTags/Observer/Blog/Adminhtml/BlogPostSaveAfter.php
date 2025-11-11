<?php

namespace Healthviet\OgTags\Observer\Blog\Adminhtml;

use Magento\Framework\Event\ObserverInterface;
use Healthviet\OgTags\Model\Blog\PostFactory as OgFactory;
use Magefan\OgTags\Observer\AbstractSaveBefore;

/**
 * Class CmsPageSaveBefore
 * @package Magefan\OgTags\Observer\Cms\Adminhtml\Page
 */
class BlogPostSaveAfter extends AbstractSaveBefore implements ObserverInterface
{
    /**
     * CmsPageSaveBefore constructor.
     * @param OgFactory $pageFactory
     * @param string $field
     */
    public function __construct(
        OgFactory $pageFactory,
        $field = 'post_id'
    ) {
        parent::__construct($pageFactory, $field);
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->save($observer->getObject());
    }
}
