<?php


namespace Healthviet\Blog\Api\Data;


interface NewsInterface
{
    const POST_ID = 'post_id';
    const IDENTIFIER = 'identifier';
    const TITLE = 'title';
    const AUTHOR = 'author';
    const TAGS = 'tags';
    const CONTENT = 'content';
    const SHORT_CONTENT = 'short_content';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME = 'update_time';
    const IMAGE = 'image';
    const COMMENTS_ENABLED = 'comments_enabled';
    const COMMENTS = 'comments';

    /**
     * @return mixed
     */
    public function getPostId();

    /**
     * @param int $postId
     * @return $this
     */
    public function setPostId($postId);

    /**
     * @return mixed
     */
    public function getIdentifier();

    /**
     * @param string $identifier
     * @return $this
     */
    public function setIdentifier($identifier);

    /**
     * @return mixed
     */
    public function getTitle();

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title);

    /**
     * @return mixed
     */
    public function getAuthor();

    /**
     * @param string $author
     * @return $this
     */
    public function setAuthor($author);

    /**
     * @return mixed
     */
    public function getTags();

    /**
     * @param string $tags
     * @return $this
     */
    public function setTags($tags);

    /**
     * @return mixed
     */
    public function getContent();

    /**
     * @param string $content
     * @return $this
     */
    public function setContent($content);

    /**
     * @return mixed
     */
    public function getShortContent();

    /**
     * @param string $shortContent
     * @return $this
     */
    public function setShortContent($shortContent);

    /**
     * @return mixed
     */
    public function getCreationTime();

    /**
     * @param string $creationTime
     * @return $this
     */
    public function setCreationTime($creationTime);

    /**
     * @return mixed
     */
    public function getUpdateTime();

    /**
     * @param string $updateTime
     * @return $this
     */
    public function setUpdateTime($updateTime);

    /**
     * @return mixed
     */
    public function getImage();

    /**
     * @param string $image
     * @return $this
     */
    public function setImage($image);

    /**
     * @return mixed
     */
    public function getCommentsEnabled();

    /**
     * @param int $commentsEnabled
     * @return $this
     */
    public function setCommentsEnabled($commentsEnabled);

    /**
     * @return \Healthviet\Blog\Api\Data\NewsCommentInterface[]
     */
    public function getComments();

    /**
     * @param \Healthviet\Blog\Api\Data\NewsCommentInterface[] $comments
     * @return $this
     */
    public function setComments(array $comments);
}
