<?php
declare(strict_types=1);

namespace Healthviet\Directory\Controller\Adminhtml\Region;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Directory\Model\RegionFactory;
use Magento\Framework\View\Result\PageFactory;

class Delete extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Healthviet_Directory::region_delete';

    /**
     * @var RegionFactory
     */
    protected RegionFactory $regionFactory;

    /**
     * @param Context $context
     * @param RegionFactory $regionFactory
     */
    public function __construct(Context $context, RegionFactory $regionFactory)
    {
        parent::__construct($context);
        $this->regionFactory = $regionFactory;
    }

    /**
     *
     * @return PageFactory
     */
    public function execute()
    {
        // check if we know what should be deleted
        $region_id = $this->getRequest()->getParam('region_id');
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($region_id) {
            try {
                // init model and delete
                $model = $this->regionFactory->create()->load($region_id);
                $region_name = $model->getDefaultName();
                $model->delete();
                $this->messageManager->addSuccess(__('The '.$region_name.' Region has been deleted.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());

                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['region_id' => $region_id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('Region to delete was not found.'));

        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
