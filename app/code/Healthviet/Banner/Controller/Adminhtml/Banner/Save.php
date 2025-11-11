<?php

namespace Healthviet\Banner\Controller\Adminhtml\Banner;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;

    protected $sliderCollection;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \Healthviet\Banner\Model\ResourceModel\Slider\CollectionFactory $sliderCollection
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Healthviet\Banner\Model\ResourceModel\Slider\CollectionFactory $sliderCollection
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->sliderCollection = $sliderCollection;
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
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('banner_id');

            $model = $this->_objectManager->create(\Healthviet\Banner\Model\Banner::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Banner no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $data = $this->processImage($data);
            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Banner.'));
                $this->dataPersistor->clear('healthviet_banner_banner');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['banner_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Banner.'));
            }

            $this->dataPersistor->set('healthviet_banner_banner', $data);
            return $resultRedirect->setPath('*/*/edit', ['banner_id' => $this->getRequest()->getParam('banner_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    public function processImage(array $data): array
    {
        $this->processImageField($data, 'image');
        $this->processImageField($data, 'mobile_image');
        return $data;
    }

    private function processImageField(array &$data, string $fieldName): void
    {
        if (isset($data[$fieldName][0]['name']) && isset($data[$fieldName][0]['url'])) {
            $url = $data[$fieldName][0]['url'];
            try {
                $this->getImageUploader()->moveFileFromTmp($data[$fieldName][0]['name']);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }

            if ($url && str_contains($url, 'media')) {
                $start = strpos($url, "media");
                $data[$fieldName] = substr($url, $start + strlen("media") + 1);
            }
        } else {
            $data[$fieldName] = null;
        }
    }

    public function getImageUploader()
    {
        return \Magento\Framework\App\ObjectManager::getInstance()->create('\Healthviet\Common\Model\ImageUploader');
    }
}
