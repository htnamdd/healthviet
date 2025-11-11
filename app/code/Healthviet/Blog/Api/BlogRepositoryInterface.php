<?php

namespace Healthviet\Blog\Api;

interface BlogRepositoryInterface
{
    /**
     * @param int $pageNum
     * @param int $pageSize
     * @return \Healthviet\Blog\Api\Data\HomepageNewsSearchResultsInterface
     */
    public function getHomepageNewsList($pageNum = null, $pageSize = null);

    /**
     * @param int $pageNum
     * @param int $pageSize
     * @param int $newsId
     * @return \Healthviet\Blog\Api\Data\NewsSearchResultsInterface
     */
    public function getNews($pageNum = null, $pageSize = null, $newsId = null);

    /**
     * @param int $customerId
     * @param int $postId
     * @param string $content
     * @return \Healthviet\Blog\Api\Data\NewsCommentInterface
     */
    public function createComment($customerId, $postId, $content);

    /**
     * @param int $newsId
     * @param int $pageNum
     * @param int $pageSize
     * @return \Healthviet\Blog\Api\Data\NewsSearchResultsInterface
     */
    public function getRelatedNews($newsId, $pageNum = null, $pageSize = null);
}
