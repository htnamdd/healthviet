<?php
namespace Healthviet\Blog\Model\Category\Source;

use Healthviet\Blog\Model\Category;

class IsVisible implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var \Healthviet\Blog\Model\Category
     */
    protected $category;

    /**
     * Constructor
     *
     * @param \Healthviet\Blog\Model\Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->category->getAvailableStatuses();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
