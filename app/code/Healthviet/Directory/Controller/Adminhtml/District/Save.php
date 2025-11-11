<?php
declare(strict_types=1);

namespace Healthviet\Directory\Controller\Adminhtml\District;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Healthviet\Directory\Model\District;
use Healthviet\Directory\Model\DistrictFactory;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Healthviet_Directory::district_edit';

    protected Registry $coreRegistry;

    /**
     * @var DataPersistorInterface
     */
    protected DataPersistorInterface $dataPersistor;

    /**
     * @var DistrictFactory
     */
    protected DistrictFactory $districtFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     * @param districtFactory $districtFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        districtFactory $districtFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->districtFactory = $districtFactory;
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
            if (empty($data['district_id'])) {
                $data['district_id'] = null;
            }


            $model = $this->districtFactory->create();
            $id = $this->getRequest()->getParam('district_id');

            if ($id) {
                try {
                    $model = $model->load($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This district no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the district.'));
                $this->dataPersistor->clear('district');

                return $this->processdistrictReturn($model, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the district.'));
            }

            $this->dataPersistor->set('district', $data);
            return $resultRedirect->setPath('*/*/edit', ['district_id' => $id]);
        }

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process and set the district return
     *
     * @param district $model
     * @param ResultInterface $resultRedirect
     * @return ResultInterface
     */
    protected function processdistrictReturn(district $model, ResultInterface $resultRedirect):ResultInterface
    {
        $returnToEdit = (bool)$this->getRequest()->getParam('back', false);

        if ($returnToEdit) {
            $resultRedirect->setPath('*/*/edit', ['district_id' => $model->getId()]);
        } else {
            $resultRedirect->setPath('*/*/');
        }

        return $resultRedirect;
    }
}
