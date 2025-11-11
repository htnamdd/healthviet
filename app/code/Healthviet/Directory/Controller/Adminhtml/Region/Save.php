<?php
declare(strict_types=1);

namespace Healthviet\Directory\Controller\Adminhtml\Region;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Directory\Model\Region;
use Magento\Directory\Model\RegionFactory;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Healthviet_Directory::region_edit';

    protected Registry $coreRegistry;

    /**
     * @var DataPersistorInterface
     */
    protected DataPersistorInterface $dataPersistor;

    /**
     * @var RegionFactory
     */
    protected RegionFactory $regionFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     * @param RegionFactory $regionFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        RegionFactory $regionFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->regionFactory = $regionFactory;
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
            if (empty($data['region_id'])) {
                $data['region_id'] = null;
            }


            $model = $this->regionFactory->create();

            $id = $this->getRequest()->getParam('region_id');
            if ($id) {
                try {
                    $model = $model->load($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This region no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the region.'));
                $this->dataPersistor->clear('region');

                return $this->processRegionReturn($model, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the region.'));
            }

            $this->dataPersistor->set('region', $data);
            return $resultRedirect->setPath('*/*/edit', ['region_id' => $id]);
        }

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process and set the region return
     *
     * @param Region $model
     * @param ResultInterface $resultRedirect
     * @return ResultInterface
     */
    protected function processRegionReturn(Region $model, ResultInterface $resultRedirect):ResultInterface
    {
        $returnToEdit = (bool)$this->getRequest()->getParam('back', false);

        if ($returnToEdit) {
            $resultRedirect->setPath('*/*/edit', ['region_id' => $model->getId()]);
        } else {
            $resultRedirect->setPath('*/*/');
        }

        return $resultRedirect;
    }
}
