<?php
declare(strict_types=1);

namespace Healthviet\Doctor\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface DoctorRepositoryInterface
{

    /**
     * Save Doctor
     * @param \Healthviet\Doctor\Api\Data\DoctorInterface $doctor
     * @return \Healthviet\Doctor\Api\Data\DoctorInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Healthviet\Doctor\Api\Data\DoctorInterface $doctor
    );

    /**
     * Retrieve Doctor
     * @param string $doctorId
     * @return \Healthviet\Doctor\Api\Data\DoctorInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($doctorId);

    /**
     * Retrieve Doctor matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Healthviet\Doctor\Api\Data\DoctorSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Doctor
     * @param \Healthviet\Doctor\Api\Data\DoctorInterface $doctor
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Healthviet\Doctor\Api\Data\DoctorInterface $doctor
    );

    /**
     * Delete Doctor by ID
     * @param string $doctorId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($doctorId);
}

