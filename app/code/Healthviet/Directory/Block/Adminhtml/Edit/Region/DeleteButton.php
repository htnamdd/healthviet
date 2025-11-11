<?php
declare(strict_types=1);

namespace Healthviet\Directory\Block\Adminhtml\Edit\Region;

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
        if ($this->getRegionId()) {
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
        return $this->getUrl('*/*/delete', ['region_id' => $this->getRegionId()]);
    }

    /**
     * Return region id
     *
     * @return int
     */
    public function getRegionId(): int
    {
        return (int) $this->context->getRequest()->getParam('region_id');
    }
}
