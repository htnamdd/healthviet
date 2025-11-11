<?php
declare(strict_types=1);

namespace Healthviet\Directory\Controller\Adminhtml\Ward;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Registry;
use Healthviet\Directory\Controller\Adminhtml\Directory;
use Healthviet\Directory\Model\WardFactory;

class Edit extends Directory
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Healthviet_Directory::ward_edit';

    /**
     * @var Registry
     */
    protected Registry $coreRegistry;

    /**
     * @var wardFactory
     */
    protected wardFactory $wardFactory;

    /**
     * @param Registry $coreRegistry
     * @param wardFactory $wardFactory
     * @param Context $context
     */
    public function __construct(Registry $coreRegistry, wardFactory $wardFactory, Context $context)
    {
        $this->coreRegistry = $coreRegistry;
        $this->wardFactory = $wardFactory;
        parent::__construct($context);
    }

    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface|ResponseInterface
     * @throws NotFoundException
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('ward_id');
        $model = $this->wardFactory->create();

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This ward no longer exists.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->coreRegistry->register('ward', $model);

        // 5. Build edit form
        $resultPage = $this->initPage($this->resultFactory->create(ResultFactory::TYPE_PAGE));
        $resultPage->addBreadcrumb(__('Ward'), __('Ward'))
            ->addBreadcrumb(
                $id ? __('Edit Ward') : __('New Ward'),
                $id ? __('Edit Ward') : __('New Ward')
            );
        $resultPage->getConfig()->getTitle()->prepend(__('Ward'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getTitle() : __('New Ward'));

        return $resultPage;
    }
}
