<?php

namespace Healthviet\Sitemap\Model\ItemProvider;

use Healthviet\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Sitemap\Model\ItemProvider\ConfigReaderInterface;
use Magento\Sitemap\Model\SitemapItemInterfaceFactory;

class Blog
{
    /**
     * Sitemap item factory
     *
     * @var SitemapItemInterfaceFactory
     */
    private $itemFactory;

    /**
     * Config reader
     *
     * @var ConfigReaderInterface
     */
    private $configReader;

    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @param ConfigReaderInterface $configReader
     * @param SitemapItemInterfaceFactory $itemFactory
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        ConfigReaderInterface       $configReader,
        SitemapItemInterfaceFactory $itemFactory,
        CollectionFactory           $collectionFactory
    )
    {
        $this->itemFactory = $itemFactory;
        $this->configReader = $configReader;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getItems($storeId)
    {
        $items = [];
        $collection = $this->getBlogCollection($storeId);
        foreach ($collection as $item) {
            $this->prepareBlogImage($item);
            $items[] = $this->itemFactory->create([
                'url' => 'blog/' . ltrim($item->getIdentifier(), '/'),
                'updatedAt' => $item->getUpdateTime(),
                'images' => $item->getImages(),
                'priority' => $this->configReader->getPriority($storeId),
                'changeFrequency' => $this->configReader->getChangeFrequency($storeId),
            ]);
        }

        return $items;
    }

    private function getBlogCollection($storeId)
    {
        $collection = $this->collectionFactory->create();
        $collection->getSelect()->join(
            ['store_table' => 'tm_blog_post_store'],
            'main_table.post_id = store_table.post_id',
            []
        )
            ->where('is_visible = ?', 1)
            ->where('store_id in (?)', [0, $storeId]);

        return $collection;
    }

    private function prepareBlogImage($blog)
    {
        $imagesCollection = [
            new \Magento\Framework\DataObject(
                ['url' => $blog->getImage()]
            ),
        ];

        $blog->setImages(
            new \Magento\Framework\DataObject(
                [
                    'collection' => $imagesCollection,
                    'title' => $blog->getTitle(),
                    'thumbnail' => $imagesCollection[0]->getUrl()
                ]
            )
        );
    }
}
