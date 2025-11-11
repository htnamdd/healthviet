<?php


namespace Healthviet\Banner\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface SliderRepositoryInterface
{

    /**
     * Save Slider
     * @param \Healthviet\Banner\Api\Data\SliderInterface $slider
     * @return \Healthviet\Banner\Api\Data\SliderInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Healthviet\Banner\Api\Data\SliderInterface $slider
    );

    /**
     * Retrieve Slider
     * @param string $sliderId
     * @return \Healthviet\Banner\Api\Data\SliderInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($sliderId);

    /**
     * Retrieve Slider matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Healthviet\Banner\Api\Data\SliderSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Slider
     * @param \Healthviet\Banner\Api\Data\SliderInterface $slider
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Healthviet\Banner\Api\Data\SliderInterface $slider
    );

    /**
     * Delete Slider by ID
     * @param string $sliderId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($sliderId);
}
