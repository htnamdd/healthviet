<?php

namespace Healthviet\Doctor\Controller;

use Healthviet\Doctor\Model\DoctorFactory;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Registry;

class Router implements \Magento\Framework\App\RouterInterface
{
    const MODULE_PATH = 'doctor';

    protected $_actionFactory;

    protected $_doctorFactory;

    protected $_registry;

    public function __construct(
        ActionFactory $actionFactory,
        DoctorFactory $doctorFactory,
        Registry $registry,
    ) {
        $this->_doctorFactory = $doctorFactory;
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
                $doctor = $this->_doctorFactory->create()->load($pathInfo[1]);
                if ($doctor->getId()) {
                    $this->_registry->register('healthviet_doctor_doctor', $doctor);
                    $modulePath .= '/doctor/view';
                }
            }
            $request->setPathInfo($modulePath);
            return $this->_actionFactory->create('Magento\Framework\App\Action\Forward');
        }
        return null;
    }
}
