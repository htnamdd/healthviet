<?php
declare(strict_types=1);

namespace Healthviet\CustomerFeedback\Api\Data;

interface CustomerFeedbackInterface
{

    const CUSTOMERFEEDBACK_ID = 'customerfeedback_id';
    const NAME = 'name';
    const CONTENT = 'content';
    const AVATAR = 'avatar';
    const ADDRESS = 'address';
    const EXPERIENCE = 'experience';

    /**
     * Get customerfeedback_id
     * @return string|null
     */
    public function getCustomerfeedbackId();

    /**
     * Set customerfeedback_id
     * @param string $customerfeedbackId
     * @return \Healthviet\CustomerFeedback\CustomerFeedback\Api\Data\CustomerFeedbackInterface
     */
    public function setCustomerfeedbackId($customerfeedbackId);

    /**
     * Get name
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return \Healthviet\CustomerFeedback\CustomerFeedback\Api\Data\CustomerFeedbackInterface
     */
    public function setName($name);

    /**
     * Get avatar
     * @return string|null
     */
    public function getAvatar();

    /**
     * Set avatar
     * @param string $avatar
     * @return \Healthviet\CustomerFeedback\CustomerFeedback\Api\Data\CustomerFeedbackInterface
     */
    public function setAvatar($avatar);

    /**
     * Get address
     * @return string|null
     */
    public function getAddress();

    /**
     * Set address
     * @param string $address
     * @return \Healthviet\CustomerFeedback\CustomerFeedback\Api\Data\CustomerFeedbackInterface
     */
    public function setAddress($address);

    /**
     * Get experience
     * @return string|null
     */
    public function getExperience();

    /**
     * Set experience
     * @param string $experience
     * @return \Healthviet\CustomerFeedback\CustomerFeedback\Api\Data\CustomerFeedbackInterface
     */
    public function setExperience($experience);

    /**
     * Get content
     * @return string|null
     */
    public function getContent();

    /**
     * Set content
     * @param string $content
     * @return \Healthviet\CustomerFeedback\CustomerFeedback\Api\Data\CustomerFeedbackInterface
     */
    public function setContent($content);
}

