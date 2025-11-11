<?php
declare(strict_types=1);

namespace Healthviet\Directory\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;

abstract class Directory extends Action implements HttpGetActionInterface
{
    /**
     * Init page
     *
     * @param Page $resultPage
     * @return Page
     */
    protected function initPage(Page $resultPage): Page
    {
        $resultPage->setActiveMenu('Magento_Backend::stores');

        return $resultPage;
    }

}
