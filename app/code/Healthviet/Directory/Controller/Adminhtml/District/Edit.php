<?php
declare(strict_types=1);

namespace Healthviet\Directory\Controller\Adminhtml\District;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Registry;
use Healthviet\Directory\Controller\Adminhtml\Directory;
use Healthviet\Directory\Model\DistrictFactory;

class Edit extends Directory
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Healthviet_Directory::district_edit';

    /**
     * @var Registry
     */
    protected Registry $coreRegistry;

    /**
     * @var DistrictFactory
     */
    protected DistrictFactory $districtFactory;

    /**
     * @param Registry $coreRegistry
     * @param DistrictFactory $districtFactory
     * @param Context $context
     */
    public function __construct(Registry $coreRegistry, DistrictFactory $districtFactory, Context $context)
    {
        $this->coreRegistry = $coreRegistry;
        $this->districtFactory = $districtFactory;
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
        $id = $this->getRequest()->getParam('district_id');
        $model = $this->districtFactory->create();

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This district no longer exists.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->coreRegistry->register('District', $model);

        // 5. Build edit form
        $resultPage = $this->initPage($this->resultFactory->create(ResultFactory::TYPE_PAGE));
        $resultPage->addBreadcrumb(__('District'), __('District'))
            ->addBreadcrumb(
                $id ? __('Edit District') : __('New District'),
                $id ? __('Edit District') : __('New District')
            );
        $resultPage->getConfig()->getTitle()->prepend(__('Districts'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getTitle() : __('New District'));

        return $resultPage;
    }
}
