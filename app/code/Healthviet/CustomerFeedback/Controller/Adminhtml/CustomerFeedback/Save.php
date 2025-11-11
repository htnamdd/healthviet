<?php
declare(strict_types=1);

namespace Healthviet\CustomerFeedback\Controller\Adminhtml\CustomerFeedback;

use Healthviet\Blog\Helper\Data;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    protected $dataPersistor;
    private Data $data;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        Data $data
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
        $this->data = $data;
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
            $id = $this->getRequest()->getParam('customerfeedback_id');

            $model = $this->_objectManager->create(\Healthviet\CustomerFeedback\Model\CustomerFeedback::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Customerfeedback no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $data = $this->processImage($data);
            $data['identifier'] = $this->data->removeVietnameseAccentsAndConcat(
                $data['name'],
                '-'
            ) . '-' . $this->data->removeVietnameseAccentsAndConcat($data['address'], '-');
            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Customerfeedback.'));
                $this->dataPersistor->clear('healthviet_customerfeedback_customerfeedback');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['customerfeedback_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('Something went wrong while saving the Customerfeedback.')
                );
            }

            $this->dataPersistor->set('healthviet_customerfeedback_customerfeedback', $data);
            return $resultRedirect->setPath(
                '*/*/edit',
                ['customerfeedback_id' => $this->getRequest()->getParam('customerfeedback_id')]
            );
        }
        return $resultRedirect->setPath('*/*/');
    }

    public function processImage(array $data): array
    {
        $avatar = $data['avatar'][0]['name'] ?? null;
        $avatarUrl = $data['avatar'][0]['url'] ?? null;

        if ($avatar !== null) {
            try {
                $this->getImageUploader()->moveFileFromTmp($avatar);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        if ($avatarUrl && str_contains($avatarUrl, 'media')) {
            $start = strpos($avatarUrl, "media");
            $avatarUrl = substr($avatarUrl, $start + strlen("media") + 1);
        }
        $data['avatar'] = $avatarUrl;

        return $data;
    }

    public function getImageUploader()
    {
        return \Magento\Framework\App\ObjectManager::getInstance()->create('\Healthviet\Common\Model\ImageUploader');
    }
}
