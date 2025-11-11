<?php

namespace Healthviet\Common\Plugin\Magento\Ui\Component\Form\Element\DataType;

/**
 * Class Image
 * @package Healthviet\Common\Plugin\Magento\Ui\Component\Form\Element\DataType
 */
class Image
{
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Healthviet\Common\Helper\Data
     */
    protected $configHelper;

    /**
     * Image constructor.
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Healthviet\Common\Helper\Data $configHelper
     */
    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Healthviet\Common\Helper\Data $configHelper
    )
    {
        $this->request = $request;
        $this->configHelper = $configHelper;
    }

    /**
     * @param \Magento\Ui\Component\AbstractComponent $subject
     */
    public function afterPrepare(\Magento\Ui\Component\AbstractComponent $subject)
    {

        $actionSource = $this->request->getModuleName() . "_" . $this->request->getControllerName();
        $limitFileSize = $this->configHelper->getValue(\Healthviet\Common\Helper\Data::IMAGE_SIZE_LIMIT) * 1024;
        $fileTypeAllowed = $this->configHelper->getValue(\Healthviet\Common\Helper\Data::TYPE_IMAGE_ALLOW);
        $data = array_replace_recursive(
            $subject->getData(),
            [
                'config' => [
                    'allowedExtensionString' => isset($fileTypeAllowed) ? $fileTypeAllowed : null,
                    'maxFileSize' => isset($limitFileSize) ? $limitFileSize : 2048 * 1024,
                    "mediaGallery" => [
                        "openDialogUrl" => $subject->getContext()->getUrl('cms/wysiwyg_images/index/source/' . $actionSource, ['_secure' => true])
                    ]
                ]
            ]
        );
        $subject->setData($data);
    }
}
