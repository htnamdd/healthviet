<?php


namespace Healthviet\Blog\Model;


use Healthviet\Blog\Api\BlogRepositoryInterface;
use Healthviet\Blog\Model\ResourceModel\Post\CollectionFactory;

class BlogRepository implements BlogRepositoryInterface
{
    const DEFAULT_PAGE_NUM = 1;
    const DEFAULT_PAGE_SIZE = 8;
    const VISIBLE = 1;
    const DISABLE = 0;

    /**
     * @var CollectionFactory
     */
    protected $postCollectionFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var PostFactory
     */
    protected $post;

    /**
     * @var \Healthviet\Common\Model\Data\MetaDataFactory
     */
    protected $metaDataFactory;

    /**
     * @var \Healthviet\Common\Api\Data\ErrorInterfaceFactory
     */
    protected $errorInterfaceFactory;

    /**
     * @var \Healthviet\Blog\Api\Data\NewsSearchResultsInterfaceFactory
     */
    protected $newsSearchResultsInterfaceFactory;

    /**
     * @var \Healthviet\Blog\Api\Data\HomePageNewsSearchResultsInterfaceFactory
     */
    protected $homePageNewsSearchResultsInterfaceFactory;

    /**
     * @var \Healthviet\Blog\Api\Data\HomepageNewsInterfaceFactory
     */
    protected $homepageNewsInterfaceFactory;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
    /**
     * @var CommentFactory
     */
    private $commentFactory;
    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    private $customerFactory;
    /**
     * @var ResourceModel\Comment\CollectionFactory
     */
    private $commentCollectionFactory;

    /**
     * BlogRepository constructor.
     * @param CollectionFactory $postCollectionFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param PostFactory $post
     * @param \Healthviet\Common\Model\Data\MetaDataFactory $metaDataFactory
     * @param \Healthviet\Common\Api\Data\ErrorInterfaceFactory $errorInterfaceFactory
     * @param \Healthviet\Blog\Api\Data\NewsSearchResultsInterfaceFactory $newsSearchResultsInterfaceFactory
     * @param \Healthviet\Blog\Api\Data\HomePageNewsSearchResultsInterfaceFactory $homePageNewsSearchResultsInterfaceFactory
     * @param \Healthviet\Blog\Api\Data\HomepageNewsInterfaceFactory $homepageNewsInterfaceFactory
     * @param CollectionFactory $collectionFactory
     * @param CommentFactory $commentFactory
     * @param \Magento\Customer\Model\CustomerFactory $customerFactory
     * @param ResourceModel\Comment\CollectionFactory $commentCollectionFactory
     */
    public function __construct(
        CollectionFactory $postCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Healthviet\Blog\Model\PostFactory $post,
        \Healthviet\Common\Model\Data\MetaDataFactory $metaDataFactory,
        \Healthviet\Common\Api\Data\ErrorInterfaceFactory $errorInterfaceFactory,
        \Healthviet\Blog\Api\Data\NewsSearchResultsInterfaceFactory $newsSearchResultsInterfaceFactory,
        \Healthviet\Blog\Api\Data\HomepageNewsSearchResultsInterfaceFactory $homePageNewsSearchResultsInterfaceFactory,
        \Healthviet\Blog\Api\Data\HomepageNewsInterfaceFactory $homepageNewsInterfaceFactory,
        \Healthviet\Blog\Model\ResourceModel\Post\CollectionFactory $collectionFactory,
        \Healthviet\Blog\Model\CommentFactory $commentFactory,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Healthviet\Blog\Model\ResourceModel\Comment\CollectionFactory $commentCollectionFactory
    )
    {
        $this->postCollectionFactory = $postCollectionFactory;
        $this->storeManager = $storeManager;
        $this->post = $post;
        $this->metaDataFactory = $metaDataFactory;
        $this->errorInterfaceFactory = $errorInterfaceFactory;
        $this->newsSearchResultsInterfaceFactory = $newsSearchResultsInterfaceFactory;
        $this->homePageNewsSearchResultsInterfaceFactory = $homePageNewsSearchResultsInterfaceFactory;
        $this->homepageNewsInterfaceFactory = $homepageNewsInterfaceFactory;
        $this->collectionFactory = $collectionFactory;
        $this->commentFactory = $commentFactory;
        $this->customerFactory = $customerFactory;
        $this->commentCollectionFactory = $commentCollectionFactory;
    }

    /**
     * @param int $pageNum
     * @param int $pageSize
     * @return \Healthviet\Blog\Api\Data\HomePageNewsSearchResultsInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getHomepageNewsList($pageNum = null, $pageSize = null)
    {
        $pageNum = $pageNum ?: self::DEFAULT_PAGE_NUM;
        $pageSize = $pageSize ?: self::DEFAULT_PAGE_SIZE;
        $postCollection = $this->postCollectionFactory->create()
            ->addFieldToFilter('is_visible', self::VISIBLE)
            ->addStoreFilter($this->storeManager->getStore()->getId());
        $postCollection->getSelect()->order('creation_time desc')->limitPage($pageNum, $pageSize);

        return $this->getHomepageNewsSearchResult($postCollection, $pageNum, $pageSize);
    }

    public function getNews($pageNum = null, $pageSize = null, $newsId = null)
    {
        $pageNum = $pageNum ?: self::DEFAULT_PAGE_NUM;
        $pageSize = $pageSize ?: self::DEFAULT_PAGE_SIZE;
        $postCollection = $this->postCollectionFactory->create();
        $postCollection
            ->addFieldToFilter('is_visible', true)
            ->addStoreFilter($this->storeManager->getStore()->getId());
        if ($newsId) {
            $postCollection->addFieldToFilter('post_id', $newsId);
        }
        $postCollection
            ->setOrder('creation_time')
            ->setCurPage($pageNum)
            ->setPageSize($pageSize);

        $comments = $this->getCommentItems($postCollection);
        foreach ($postCollection as $item) {
            if (isset($comments[$item->getPostId()])) {
                $item->setComments($comments[$item->getPostId()]);
            }
        }
        return $this->getNewsSearchResult($postCollection, $pageNum, $pageSize);
    }

    public function getRelatedNews($newsId, $pageNum = null, $pageSize = null)
    {
        $pageNum = $pageNum ?: self::DEFAULT_PAGE_NUM;
        $pageSize = $pageSize ?: self::DEFAULT_PAGE_SIZE;
        $postCollection = $this->postCollectionFactory->create();
        $postCollection
            ->addFieldToFilter('is_visible', true)
            ->addStoreFilter($this->storeManager->getStore()->getId());
        if ($newsId) {
            $postCollection->addFieldToFilter('post_id', ['neq' => $newsId]);
        }
        $postCollection
            ->setOrder('creation_time')
            ->setCurPage($pageNum)
            ->setPageSize($pageSize);

        $comments = $this->getCommentItems($postCollection);
        foreach ($postCollection as $item) {
            if (isset($comments[$item->getPostId()])) {
                $item->setComments($comments[$item->getPostId()]);
            }
        }
        return $this->getNewsSearchResult($postCollection, $pageNum, $pageSize);
    }

    private function getCommentItems($postCollection)
    {
        $commentCollection = $this->commentCollectionFactory->create();
        $commentCollection->addFieldToFilter('post_id', ['in' => $postCollection->getAllIds()]);
        $comments = [];
        foreach ($commentCollection as $item) {
            $comments[$item->getPostId()][] = $item;
        }

        return $comments;
    }

    /**
     * @param int $customerId
     * @param int $postId
     * @param string $content
     * @return \Healthviet\Blog\Api\Data\NewsCommentInterface
     */
    public function createComment($customerId, $postId, $content)
    {
        if ($postId && $customerId) {
            $customer = $this->customerFactory->create()->load($customerId);
            $comment = $this->commentFactory->create();
            $comment->setData([
                'post_id' => $postId,
                'status' => \Healthviet\Blog\Model\Comment::STATUS_PENDING,
                'author' => $customer->getName(),
                'email' => $customer->getEmail(),
                'content' => $content,
                'creation_time' => date("Y-m-d H:i:s"),
                'update_time' => date("Y-m-d H:i:s"),
            ]);
            $comment->save();

            return $comment;
        }

        return [];
    }


    public function getNewsSearchResult($collection, $pageNum, $pageSize)
    {
        $metaData = $this->metaDataFactory->create();
        $metaData->setTotal($collection->getSize())->setPageNum($pageNum)->setPageSize($pageSize);
        $newsSearchResult = $this->newsSearchResultsInterfaceFactory->create();
        if ($collection->getSize() <= 0) {
            $error = $this->errorInterfaceFactory->create();
            $error->setCode('404')->setMsg('Not found!');
            $newsSearchResult->setError($error);
        }
        foreach ($collection as $item) {
            $item->setContent(strip_tags($item->getContent()));
        }
        $newsSearchResult
            ->setItems($collection->getItems())
            ->setMetaData($metaData);

        return $newsSearchResult;
    }

    public function getHomepageNewsSearchResult($collection, $pageNum, $pageSize)
    {
        $metaData = $this->metaDataFactory->create();
        $metaData->setTotal($collection->getSize())->setPageNum($pageNum)->setPageSize($pageSize);
        $homepageNewsSearchResult = $this->homePageNewsSearchResultsInterfaceFactory->create();
        if ($collection->getSize() <= 0) {
            $error = $this->errorInterfaceFactory->create();
            $error->setCode('404')->setMsg('Not found!');
            $homepageNewsSearchResult->setError($error);
        }


        $standoutPosts = [];
        $otherPosts = [];
        $count = 0;
        foreach ($collection as $item) {
            if ($count < 2) {
                $standoutPosts[] = $item;
                $count++;
            } else {
                $otherPosts[] = $item;
            }
        }
        $homepageNews = $this->homepageNewsInterfaceFactory->create();
        $homepageNews
            ->setStandoutNews($standoutPosts)
            ->setOtherNews($otherPosts);

        $homepageNewsSearchResult
            ->setItems($homepageNews)
            ->setMetaData($metaData);

        return $homepageNewsSearchResult;
    }
}
