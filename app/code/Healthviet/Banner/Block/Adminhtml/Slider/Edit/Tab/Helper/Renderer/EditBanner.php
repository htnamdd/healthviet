<?php


namespace Healthviet\Banner\Block\Adminhtml\Slider\Edit\Tab\Helper\Renderer;


class EditBanner extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * Render action.
     *
     * @param \Magento\Framework\DataObject $row
     *
     * @return string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        return '<a href="' . $this->getUrl('*/banner/edit', ['_current' => false, 'banner_id' => $row->getId()])
            . '" target="popup" onclick="window.open(\''.$this->getUrl('*/banner/edit', ['_current' => false, 'banner_id' => $row->getId()]).'\',\'popup\',\'width=600,scrollbars=no,resizable=no\'); return false;">Edit</a> ';
    }
}
