<?php


namespace Healthviet\Common\Model\Data;


use Healthviet\Common\Api\Data\ErrorInterface;

class Error extends \Magento\Framework\Api\AbstractExtensibleObject implements ErrorInterface
{
    public function getCode()
    {
        return $this->_get(self::CODE);
    }

    public function setCode($code)
    {
        return $this->setData(self::CODE, $code);
    }

    public function getMsg()
    {
        return $this->_get(self::MSG);
    }

    public function setMsg($msg)
    {
        return $this->setData(self::MSG, $msg);
    }
}
