<?php
declare(strict_types=1);

namespace Healthviet\CustomerFeedback\Controller\Adminhtml\CustomerFeedback;

class Edit extends \Healthviet\CustomerFeedback\Controller\Adminhtml\CustomerFeedback
{

    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('customerfeedback_id');
        $model = $this->_objectManager->create(\Healthviet\CustomerFeedback\Model\CustomerFeedback::class);
        
        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Customerfeedback no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('healthviet_customerfeedback_customerfeedback', $model);
        
        // 3. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Customerfeedback') : __('New Customerfeedback'),
            $id ? __('Edit Customerfeedback') : __('New Customerfeedback')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Customerfeedbacks'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Customerfeedback %1', $model->getId()) : __('New Customerfeedback'));
        return $resultPage;
    }
}

