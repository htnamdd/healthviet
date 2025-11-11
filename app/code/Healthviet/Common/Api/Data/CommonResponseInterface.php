<?php

namespace Healthviet\Common\Api\Data;

interface CommonResponseInterface
{
    const ERROR = 'error';
    const META_DATA = 'meta_data';

    /**
     * @return \Healthviet\Common\Api\Data\ErrorInterface
     */
    public function getError();

    /**
     * @param \Healthviet\Common\Api\Data\ErrorInterface $error
     * @return $this
     */
    public function setError(\Healthviet\Common\Api\Data\ErrorInterface $error);

    /**
     * @return \Healthviet\Common\Api\Data\MetaDataInterface
     */
    public function getMetaData();

    /**
     * @param \Healthviet\Common\Api\Data\MetaDataInterface $metaData
     * @return $this
     */
    public function setMetaData(\Healthviet\Common\Api\Data\MetaDataInterface $metaData);
}
