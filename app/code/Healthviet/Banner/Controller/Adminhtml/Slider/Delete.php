<?php


namespace Healthviet\Banner\Controller\Adminhtml\Slider;

class Delete extends \Healthviet\Banner\Controller\Adminhtml\Slider
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
        $id = $this->getRequest()->getParam('slider_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create(\Healthviet\Banner\Model\Slider::class);
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Slider.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['slider_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Slider to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
