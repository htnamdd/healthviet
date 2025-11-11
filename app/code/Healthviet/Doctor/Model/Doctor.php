<?php
declare(strict_types=1);

namespace Healthviet\Doctor\Model;

use Healthviet\Doctor\Api\Data\DoctorInterface;
use Magento\Framework\Model\AbstractModel;

class Doctor extends AbstractModel implements DoctorInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\Healthviet\Doctor\Model\ResourceModel\Doctor::class);
    }

    /**
     * @inheritDoc
     */
    public function getDoctorId()
    {
        return $this->getData(self::DOCTOR_ID);
    }

    /**
     * @inheritDoc
     */
    public function setDoctorId($doctorId)
    {
        return $this->setData(self::DOCTOR_ID, $doctorId);
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getCompany()
    {
        return $this->getData(self::COMPANY);
    }

    /**
     * @inheritDoc
     */
    public function setCompany($company)
    {
        return $this->setData(self::COMPANY, $company);
    }

    /**
     * @inheritDoc
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * @inheritDoc
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * @inheritDoc
     */
    public function getAvatar()
    {
        return $this->getData(self::AVATAR);
    }

    /**
     * @inheritDoc
     */
    public function setAvatar($avatar)
    {
        return $this->setData(self::AVATAR, $avatar);
    }
}

