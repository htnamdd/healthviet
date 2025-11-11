<?php
declare(strict_types=1);

namespace Healthviet\CustomerFeedback\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface CustomerFeedbackRepositoryInterface
{

    /**
     * Save CustomerFeedback
     * @param \Healthviet\CustomerFeedback\Api\Data\CustomerFeedbackInterface $customerFeedback
     * @return \Healthviet\CustomerFeedback\Api\Data\CustomerFeedbackInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Healthviet\CustomerFeedback\Api\Data\CustomerFeedbackInterface $customerFeedback
    );

    /**
     * Retrieve CustomerFeedback
     * @param string $customerfeedbackId
     * @return \Healthviet\CustomerFeedback\Api\Data\CustomerFeedbackInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($customerfeedbackId);

    /**
     * Retrieve CustomerFeedback matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Healthviet\CustomerFeedback\Api\Data\CustomerFeedbackSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete CustomerFeedback
     * @param \Healthviet\CustomerFeedback\Api\Data\CustomerFeedbackInterface $customerFeedback
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Healthviet\CustomerFeedback\Api\Data\CustomerFeedbackInterface $customerFeedback
    );

    /**
     * Delete CustomerFeedback by ID
     * @param string $customerfeedbackId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($customerfeedbackId);
}

