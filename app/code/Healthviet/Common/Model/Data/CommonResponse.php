<?php

namespace Healthviet\Common\Model\Data;

class CommonResponse extends \Magento\Framework\Api\AbstractExtensibleObject implements \Healthviet\Common\Api\Data\CommonResponseInterface
{
    /**
     * @return \Healthviet\Common\Api\Data\ErrorInterface|mixed|null
     */
    public function getError()
    {
        $error = $this->_get(self::ERROR);
        return is_array($error) ? $error : [];
    }


    /**
     * @param \Healthviet\Common\Api\Data\ErrorInterface $error
     * @return CommonResponse
     */
    public function setError(\Healthviet\Common\Api\Data\ErrorInterface $error)
    {
        return $this->setData(self::ERROR, $error);
    }

    /**
     * @return \Healthviet\Common\Api\Data\MetaDataInterface
     */
    public function getMetaData()
    {
        $metaData = $this->_get(self::META_DATA);
        return is_array($metaData) ? $metaData : [];
    }

    /**
     * @param \Healthviet\Common\Api\Data\MetaDataInterface $metaData
     * @return CommonResponse
     */
    public function setMetaData(\Healthviet\Common\Api\Data\MetaDataInterface $metaData)
    {
        return $this->setData(self::META_DATA, $metaData);
    }
}
