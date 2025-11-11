<?php
/**
 * Created by PhpStorm.
 * User: quanbh
 * Date: 15/01/2019
 * Time: 16:59
 */

namespace Healthviet\Doctor\Controller\Adminhtml\Doctor;
use Magento\Framework\Controller\ResultFactory;

class UploadAvatar extends \Magento\Backend\App\Action
{
    public $imageUploader;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Healthviet\Banner\Model\Uploader\BannerImage $imageUploader
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Healthviet_Doctor::Doctor');
    }

    public function execute()
    {
        try {
            $result = $this->imageUploader->saveFileToTmpDir('avatar');
            $session = $this->_getSession();

            $result['cookie'] = [
                'name' => $session->getName(),
                'value' => $session->getSessionId(),
                'lifetime' => $session->getCookieLifetime(),
                'path' => $session->getCookiePath(),
                'domain' => $session->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
