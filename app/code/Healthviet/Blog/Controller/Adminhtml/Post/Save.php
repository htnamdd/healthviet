<?php

namespace Healthviet\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Healthviet\Blog\Model\PostFactory
     */
    protected $postFactory;

    /**
     * @var \Magento\Backend\Model\Session
     */
    protected $_session;

    /**
     * @var \Magento\Framework\App\Cache\TypeListInterface
     */
    protected $cacheTypeList;

    /**
     * @var \Healthviet\Common\Helper\Data
     */
    protected $healthvietConfiguration;

    /**
     * @var false|string[]
     */
    protected $allowedExtensions;

    /**
     * @var \Magento\Framework\Filesystem\Driver\File
     */
    protected $file;

    /**
     * @var \Healthviet\Blog\Helper\Data
     */
    protected \Healthviet\Blog\Helper\Data $data;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param \Healthviet\Blog\Model\PostFactory $postFactory
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Healthviet\Common\Helper\Data $healthvietConfiguration
     * @param \Magento\Framework\Filesystem\Driver\File $file
     */
    public function __construct(
        Action\Context $context,
        \Healthviet\Blog\Model\PostFactory $postFactory,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Healthviet\Common\Helper\Data $healthvietConfiguration,
        \Magento\Framework\Filesystem\Driver\File $file,
        \Healthviet\Blog\Helper\Data $data
    )
    {
        //$this->_session = $session;
        $this->_session = $context->getSession();
        $this->postFactory = $postFactory;
        $this->cacheTypeList = $cacheTypeList;
        $this->healthvietConfiguration = $healthvietConfiguration;
        $typeImageAllow = $this->healthvietConfiguration->getValue(\Healthviet\Common\Helper\Data::TYPE_IMAGE_ALLOW);
        if (isset($typeImageAllow))
            $this->allowedExtensions = explode(',', $typeImageAllow);
        $this->file = $file;
        parent::__construct($context);
        $this->data = $data;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Healthviet_Blog::post_save');
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var \Healthviet\Blog\Model\Post $model */
            $model = $this->postFactory->create();

            $id = $this->getRequest()->getParam('post_id');
            if ($id) {
                $model->load($id);
            }
            $data['identifier'] = $this->data->removeVietnameseAccentsAndConcat($data['title'], '-');
            $model->setData($data);

            $this->_eventManager->dispatch(
                'blog_post_prepare_save',
                ['post' => $model, 'request' => $this->getRequest()]
            );

            try {
                $fields = ['post_image', 'file_path'];
                $fileSystem = $this->_objectManager->create('Magento\Framework\Filesystem');
                $mediaDirectory = $fileSystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);

                foreach ($fields as $field) {
                    if (isset($data[$field]) && isset($data[$field]['value'])) {
                        if (isset($data[$field]['delete'])) {
                            $fileName = $mediaDirectory->getAbsolutePath() . $data[$field]['value'];
                            if ($this->file->isExists($fileName)){
                                unlink($fileName);
                            }
                            if ($field == 'post_image') {
                                $model->setData('image');
                            } else {
                                $model->setData($field, '');
                            }
                        } else {
                            $model->unsetData($field);
                        }
                    }
                    try {
                        $result = $this->uploadFile($field, $this->allowedExtensions, $mediaDirectory);
                        if ($field == 'post_image') {
                            $model->setData('image', 'tm_blog' . $result['file']);
                        } else {
                            $model->setData($field, 'tm_blog' . $result['file']);
                        }
                    } catch (\Exception $e) {
                        if ($e->getCode() != \Magento\Framework\File\Uploader::TMP_NAME_EMPTY) {
                            $this->messageManager->addError($e->getMessage());
                        }
                    }
                }
                $model->save();
                $this->messageManager->addSuccess(__('You saved this Post.'));

                $this->cacheTypeList->invalidate('full_page');

                $this->_session->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['post_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the post.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['post_id' => $this->getRequest()->getParam('post_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    private function uploadFile($field, $allowExtension, $mediaDirectory)
    {
        $uploader = $this->_objectManager->create('Magento\MediaStorage\Model\File\UploaderFactory');
        $uploader = $uploader->create(['fileId' => $field]);
        $uploader->setAllowedExtensions($allowExtension);
        $uploader->setAllowRenameFiles(true);
        $uploader->setFilesDispersion(true);
        $uploader->setAllowCreateFolders(true);
        $result = $uploader->save(
            $mediaDirectory->getAbsolutePath('tm_blog')
        );

        return $result;
    }
}
