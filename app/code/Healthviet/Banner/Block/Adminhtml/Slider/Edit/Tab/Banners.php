<?php


namespace Healthviet\Banner\Block\Adminhtml\Slider\Edit\Tab;


class Banners extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * banner factory.
     *
     * @var \Healthviet\Banner\Model\ResourceModel\Banner\CollectionFactory
     */
    protected $bannerCollectionFactory;

    /**
     * [__construct description].
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Healthviet\Banner\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Healthviet\Banner\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $backendHelper, $data);

        $this->bannerCollectionFactory = $bannerCollectionFactory;
    }

    /**
     * _construct
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('bannerGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);

    }

    /**
     * prepare collection
     */
    protected function _prepareCollection()
    {
        $sliderId = $this->getRequest()->getParam('slider_id') ?? 0;

        /** @var \Healthviet\Banner\Model\ResourceModel\Banner\Collection $collection */
        $collection = $this->bannerCollectionFactory->create();
        $collection->addFieldToFilter("slider_id", $sliderId);
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * @return \Healthviet\Banner\Block\Adminhtml\Slider\Edit\Tab\Banners
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'banner_id',
            [
                'header' => __('Banner ID'),
                'type' => 'number',
                'index' => 'banner_id',
                'name' => 'banner_id',
                'filter' => false
            ]
        );
        $this->addColumn(
            'title',
            [
                'header' => __('Title'),
                'index' => 'title',
                'class' => 'xxx',
                'width' => '50px',
                'filter' => false,
            ]
        );
        $this->addColumn(
            'image',
            [
                'header' => __('Image'),
                'filter' => false,
                'width' => '50px',
                'renderer' => 'Healthviet\Banner\Block\Adminhtml\Banner\Helper\Renderer\Image',
            ]
        );

        $this->addColumn(
            'mobile_image',
            [
                'header' => __('Mobile Image'),
                'filter' => false,
                'width' => '50px',
                'renderer' => 'Healthviet\Banner\Block\Adminhtml\Banner\Helper\Renderer\MobileImage',
            ]
        );

        $this->addColumn(
            'sort_order',
            [
                'header' => __('Sort Order'),
                'name' => 'sort_order',
                'index' => 'sort_order',
                'width' => '50px',
                'filter' => false,
            ]
        );
        $this->addColumn(
            'edit',
            [
                'header' => __('Edit'),
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'width' => '50px',
                'renderer' => 'Healthviet\Banner\Block\Adminhtml\Slider\Edit\Tab\Helper\Renderer\EditBanner',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action',
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/bannersgrid', ['_current' => true]);
    }

    /**
     * Get row url
     * @param object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return '';
    }

    /**
     * Prepare label for tab.
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Banners');
    }

    /**
     * Prepare title for tab.
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Banners');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return true;
    }
}
