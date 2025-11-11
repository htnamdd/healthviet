<?php
declare(strict_types=1);

namespace Healthviet\Directory\Block\Adminhtml\Edit\Ward;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Healthviet\Directory\Block\Adminhtml\Edit\GenericButton;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @inheritDoc
     */
    public function getButtonData(): array
    {
        $data = [];
        if ($this->getWardId()) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->getDeleteUrl() . '\', {"data": {}})',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * URL to send delete requests to.
     *
     * @return string
     */
    public function getDeleteUrl(): string
    {
        return $this->getUrl('*/*/delete', ['ward_id' => $this->getWardId()]);
    }

    /**
     * Return region id
     *
     * @return int
     */
    public function getWardId(): int
    {
        return (int) $this->context->getRequest()->getParam('ward_id');
    }
}
