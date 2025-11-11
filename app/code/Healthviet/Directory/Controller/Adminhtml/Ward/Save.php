<?php
declare(strict_types=1);

namespace Healthviet\Directory\Controller\Adminhtml\Ward;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Healthviet\Directory\Model\Ward;
use Healthviet\Directory\Model\WardFactory;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Healthviet_Directory::ward_edit';

    protected Registry $coreRegistry;

    /**
     * @var DataPersistorInterface
     */
    protected DataPersistorInterface $dataPersistor;

    /**
     * @var wardFactory
     */
    protected wardFactory $wardFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     * @param wardFactory $wardFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        wardFactory $wardFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->wardFactory = $wardFactory;
        $this->coreRegistry = $coreRegistry;

        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            if (empty($data['ward_id'])) {
                $data['ward_id'] = null;
            }


            $model = $this->wardFactory->create();
            $id = $this->getRequest()->getParam('ward_id');

            if ($id) {
                try {
                    $model = $model->load($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This ward no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the ward.'));
                $this->dataPersistor->clear('ward');

                return $this->processWardReturn($model, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the ward.'));
            }

            $this->dataPersistor->set('ward', $data);
            return $resultRedirect->setPath('*/*/edit', ['ward_id' => $id]);
        }

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process and set the ward return
     *
     * @param ward $model
     * @param ResultInterface $resultRedirect
     * @return ResultInterface
     */
    protected function processWardReturn(ward $model, ResultInterface $resultRedirect):ResultInterface
    {
        $returnToEdit = (bool)$this->getRequest()->getParam('back', false);

        if ($returnToEdit) {
            $resultRedirect->setPath('*/*/edit', ['ward_id' => $model->getId()]);
        } else {
            $resultRedirect->setPath('*/*/');
        }

        return $resultRedirect;
    }
}
