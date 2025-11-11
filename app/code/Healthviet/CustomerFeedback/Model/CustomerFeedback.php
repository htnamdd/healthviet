<?php
declare(strict_types=1);

namespace Healthviet\CustomerFeedback\Model;

use Healthviet\CustomerFeedback\Api\Data\CustomerFeedbackInterface;
use Magento\Framework\Model\AbstractModel;

class CustomerFeedback extends AbstractModel implements CustomerFeedbackInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\Healthviet\CustomerFeedback\Model\ResourceModel\CustomerFeedback::class);
    }

    /**
     * @inheritDoc
     */
    public function getCustomerfeedbackId()
    {
        return $this->getData(self::CUSTOMERFEEDBACK_ID);
    }

    /**
     * @inheritDoc
     */
    public function setCustomerfeedbackId($customerfeedbackId)
    {
        return $this->setData(self::CUSTOMERFEEDBACK_ID, $customerfeedbackId);
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

    /**
     * @inheritDoc
     */
    public function getAddress()
    {
        return $this->getData(self::ADDRESS);
    }

    /**
     * @inheritDoc
     */
    public function setAddress($address)
    {
        return $this->setData(self::ADDRESS, $address);
    }

    /**
     * @inheritDoc
     */
    public function getExperience()
    {
        return $this->getData(self::EXPERIENCE);
    }

    /**
     * @inheritDoc
     */
    public function setExperience($experience)
    {
        return $this->setData(self::EXPERIENCE, $experience);
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
}

