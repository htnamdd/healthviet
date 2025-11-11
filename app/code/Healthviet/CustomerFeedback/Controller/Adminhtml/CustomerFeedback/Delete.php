<?php
declare(strict_types=1);

namespace Healthviet\CustomerFeedback\Controller\Adminhtml\CustomerFeedback;

class Delete extends \Healthviet\CustomerFeedback\Controller\Adminhtml\CustomerFeedback
{

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('customerfeedback_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create(\Healthviet\CustomerFeedback\Model\CustomerFeedback::class);
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Customerfeedback.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['customerfeedback_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Customerfeedback to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}

