<?php


namespace Healthviet\Blog\Api\Data;


interface NewsCommentInterface
{
    const COMMENT_ID = 'comment_id';
    const POST_ID = 'post_id';
    const STATUS = 'status';
    const AUTHOR = 'author';
    const EMAIL = 'email';
    const CONTENT = 'content';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME = 'update_time';

    /**
     * @return mixed
     */
    public function getCommentId();

    /**
     * @param string $commentId
     * @return $this
     */
    public function setCommentId($commentId);

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
    public function getStatus();

    /**
     * @param int $status
     * @return $this
     */
    public function setStatus($status);

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
    public function getEmail();

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email);

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
}
