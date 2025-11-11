<?php
declare(strict_types=1);

namespace Healthviet\Directory\Controller\Adminhtml\Ward;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;

class Index extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Healthviet_Directory::manage_ward';

    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface|ResponseInterface
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        /**
         * Set active menu item
         */
        $resultPage->setActiveMenu('Magento_Backend::stores');
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Wards'));

        /**
         * Add breadcrumb item
         */
        $resultPage->addBreadcrumb(__('Manage Districts'), __('Manage Wards'));

        return $resultPage;
    }
}
