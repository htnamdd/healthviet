<?php
declare(strict_types=1);

namespace Healthviet\Doctor\Api\Data;

interface DoctorInterface
{

    const NAME = 'name';
    const DOCTOR_ID = 'doctor_id';
    const CONTENT = 'content';
    const COMPANY = 'company';
    const AVATAR = 'avatar';

    /**
     * Get doctor_id
     * @return string|null
     */
    public function getDoctorId();

    /**
     * Set doctor_id
     * @param string $doctorId
     * @return \Healthviet\Doctor\Doctor\Api\Data\DoctorInterface
     */
    public function setDoctorId($doctorId);

    /**
     * Get name
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return \Healthviet\Doctor\Doctor\Api\Data\DoctorInterface
     */
    public function setName($name);

    /**
     * Get company
     * @return string|null
     */
    public function getCompany();

    /**
     * Set company
     * @param string $company
     * @return \Healthviet\Doctor\Doctor\Api\Data\DoctorInterface
     */
    public function setCompany($company);

    /**
     * Get content
     * @return string|null
     */
    public function getContent();

    /**
     * Set content
     * @param string $content
     * @return \Healthviet\Doctor\Doctor\Api\Data\DoctorInterface
     */
    public function setContent($content);

    /**
     * Get avatar
     * @return string|null
     */
    public function getAvatar();

    /**
     * Set avatar
     * @param string $avatar
     * @return \Healthviet\Doctor\Doctor\Api\Data\DoctorInterface
     */
    public function setAvatar($avatar);
}

