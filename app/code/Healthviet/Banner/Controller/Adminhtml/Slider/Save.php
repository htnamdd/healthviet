<?php

namespace Healthviet\Banner\Controller\Adminhtml\Slider;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $formPostValues = $this->getRequest()->getPostValue();
        if (isset($formPostValues['slider'])) {
            $sliderData = $formPostValues['slider'];
            $sliderId = isset($sliderData['id']) ? $sliderData['id'] : null;
            $model = $this->_objectManager->create(\Healthviet\Banner\Model\Slider::class)->load($sliderId);
            if (!$model->getId() && $sliderId) {
                $this->messageManager->addErrorMessage(__('This Slider no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($sliderData);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Slider.'));
                $this->dataPersistor->clear('healthviet_banner_slider');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['slider_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Slider.'));
            }

            $this->dataPersistor->set('healthviet_banner_slider', $sliderData);
            return $resultRedirect->setPath('*/*/edit', ['slider_id' => $this->getRequest()->getParam('slider_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
