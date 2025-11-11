<?php
declare(strict_types=1);

namespace Healthviet\Directory\Controller\Adminhtml\District;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Healthviet\Directory\Model\DistrictFactory;
use Magento\Framework\View\Result\PageFactory;

class Delete extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Healthviet_Directory::district_delete';

    /**
     * @var DistrictFactory
     */
    protected DistrictFactory $districtFactory;

    /**
     * @param Context $context
     * @param DistrictFactory $districtFactory
     */
    public function __construct(Context $context, DistrictFactory $districtFactory)
    {
        parent::__construct($context);
        $this->districtFactory = $districtFactory;
    }

    /**
     *
     * @return PageFactory
     */
    public function execute()
    {
        // check if we know what should be deleted
        $district_id = $this->getRequest()->getParam('district_id');
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($district_id) {
            try {
                // init model and delete
                $model = $this->districtFactory->create()->load($district_id);
                $district_name = $model->getDefaultName();
                $model->delete();
                $this->messageManager->addSuccess(__('The '.$district_name.' district has been deleted.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());

                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['district_id' => $district_id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('district to delete was not found.'));

        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
