<?php

namespace Healthviet\CustomerFeedback\Controller;

use Healthviet\CustomerFeedback\Model\CustomerFeedbackFactory;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Registry;

class Router implements \Magento\Framework\App\RouterInterface
{
    const MODULE_PATH = 'feedback';

    protected $_actionFactory;

    protected $_feedbackFactory;


    protected $_registry;

    public function __construct(
        ActionFactory $actionFactory,
        CustomerFeedbackFactory $feedbackFactory,
        Registry $registry,
    ) {
        $this->_feedbackFactory = $feedbackFactory;
        $this->_actionFactory = $actionFactory;
        $this->_registry = $registry;
    }

    /**
     * Allows to use dynamic routing
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * @return \Magento\Framework\App\ActionInterface|null
     */
    public function match(
        RequestInterface $request
    ) {
        $info = trim($request->getPathInfo(), '/');
        $pathInfo = explode('/', $info);

        if ($pathInfo[0] == self::MODULE_PATH) {
            $modulePath = self::MODULE_PATH;
            if (isset($pathInfo[1])) {
                $feedback = $this->_feedbackFactory->create()->load($pathInfo[1]);
                if ($feedback->getId()) {
                    $this->_registry->register('healthviet_feedback_feedback', $feedback);
                    $modulePath .= '/feedback/view';
                }
            }
            $request->setPathInfo($modulePath);
            return $this->_actionFactory->create('Magento\Framework\App\Action\Forward');
        }
        return null;
    }
}
