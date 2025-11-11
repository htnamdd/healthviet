<?php

namespace Healthviet\Banner\Controller\Adminhtml\Slider;

class Edit extends \Magento\Backend\App\Action
{
    protected $sliderFactory;
    protected $resultPageFactory;
    protected $coreRegistry;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Healthviet\Banner\Model\SliderFactory $sliderFactory,
        \Magento\Framework\Registry $coreRegistry
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->sliderFactory = $sliderFactory;
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $id = $this->getRequest()->getParam('slider_id');
        $model = $this->sliderFactory->create();

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This slider no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_getSession()->getFormData(true);

        if (!empty($data)) {
            $model->setData($data);
        }
        $this->coreRegistry->register('slider', $model);

        return $resultPage;
    }
}
