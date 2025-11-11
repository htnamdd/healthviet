<?php
declare(strict_types=1);

namespace Healthviet\Directory\Controller\Adminhtml\Ward;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Healthviet\Directory\Model\WardFactory;
use Magento\Framework\View\Result\PageFactory;

class Delete extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Healthviet_Directory::ward_delete';

    /**
     * @var WardFactory
     */
    protected WardFactory $wardFactory;

    /**
     * @param Context $context
     * @param WardFactory $wardFactory
     */
    public function __construct(Context $context, WardFactory $wardFactory)
    {
        parent::__construct($context);
        $this->wardFactory = $wardFactory;
    }

    /**
     *
     * @return PageFactory
     */
    public function execute()
    {
        // check if we know what should be deleted
        $ward_id = $this->getRequest()->getParam('ward_id');
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($ward_id) {
            try {
                // init model and delete
                $model = $this->wardFactory->create()->load($ward_id);
                $ward_name = $model->getDefaultName();
                $model->delete();
                $this->messageManager->addSuccess(__('The '.$ward_name.' Ward has been deleted.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());

                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['ward_id' => $ward_id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('Ward to delete was not found.'));

        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
