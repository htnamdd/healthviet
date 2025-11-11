<?php
declare(strict_types=1);

namespace Healthviet\CustomerFeedback\Api\Data;

interface CustomerFeedbackSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get CustomerFeedback list.
     * @return \Healthviet\CustomerFeedback\Api\Data\CustomerFeedbackInterface[]
     */
    public function getItems();

    /**
     * Set name list.
     * @param \Healthviet\CustomerFeedback\Api\Data\CustomerFeedbackInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

