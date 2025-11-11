<?php
declare(strict_types=1);

namespace Healthviet\Directory\Controller\Adminhtml\Region;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Directory\Model\RegionFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Healthviet\Directory\Controller\Adminhtml\Directory;

class Edit extends Directory
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Healthviet_Directory::region_edit';

    /**
     * @var Registry
     */
    protected Registry $coreRegistry;

    /**
     * @var RegionFactory
     */
    protected RegionFactory $regionFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param RegionFactory $regionFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        RegionFactory $regionFactory
    ) {
        $this->regionFactory = $regionFactory;
        $this->coreRegistry = $coreRegistry;

        parent::__construct($context);
    }

    /**
     * Edit Region
     *
     * @return ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('region_id');
        $model = $this->regionFactory->create();

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This region no longer exists.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->coreRegistry->register('region', $model);

        // 5. Build edit form
        $resultPage = $this->initPage($this->resultFactory->create(ResultFactory::TYPE_PAGE));
        $resultPage->addBreadcrumb(__('Region'), __('Region'))
                   ->addBreadcrumb(
                       $id ? __('Edit Region') : __('New Region'),
                       $id ? __('Edit Region') : __('New Region')
                   );
        $resultPage->getConfig()->getTitle()->prepend(__('Regions'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getTitle() : __('New Region'));

        return $resultPage;
    }

}
