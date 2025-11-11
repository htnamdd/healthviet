<?php


namespace Healthviet\Banner\Controller\Adminhtml\Slider;


class Banners extends \Magento\Backend\App\Action
{
    protected $sliderFactory;
    protected $resultLayoutFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
    )
    {
        $this->resultLayoutFactory = $resultLayoutFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultLayout = $this->resultLayoutFactory->create();
        $resultLayout
            ->getLayout()->getBlock('healthviet.slider.edit.tab.banners')
            ->setInBanner($this->getRequest()->getPost('banner', null));

        return $resultLayout;
    }
}
