<?php

namespace Healthviet\Common\Api\Data;

interface ErrorInterface
{
    const CODE = 'code';
    const MSG = 'msg';

    /**
     * @return string
     */
    public function getCode();

    /**
     * @param string $code
     * @return $this
     */
    public function setCode($code);

    /**
     * @return string
     */
    public function getMsg();

    /**
     * @param string $msg
     * @return $this
     */
    public function setMsg($msg);
}
