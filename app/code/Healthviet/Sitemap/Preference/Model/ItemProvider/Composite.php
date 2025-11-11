<?php

namespace Healthviet\Sitemap\Preference\Model\ItemProvider;

use Magento\Sitemap\Model\ItemProvider\ItemProviderInterface;

class Composite extends \Magento\Sitemap\Model\ItemProvider\Composite
{
    /**
     * Item resolvers
     *
     * @var ItemProviderInterface[]
     */
    private $itemProviders;

    public function __construct($itemProviders = [])
    {
        parent::__construct($itemProviders);
        $this->itemProviders = $itemProviders;
    }

    /**
     * {@inheritdoc}
     */
    public function getItems($storeId)
    {
        $items = [];

        foreach ($this->itemProviders as $key => $resolver) {
            foreach ($resolver->getItems($storeId) as $item) {
                $items[$key][] = $item;
            }
        }

        return $items;
    }
}
