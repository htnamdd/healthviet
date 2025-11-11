<?php

namespace Healthviet\Blog\Model\Data;

use Healthviet\Blog\Api\Data\NewsCommentInterface;

class NewsComment extends \Magento\Framework\Api\AbstractSimpleObject implements \Healthviet\Blog\Api\Data\NewsCommentInterface
{
    public function getCommentId()
    {
        return $this->_get(self::COMMENT_ID);
    }

    public function setCommentId($commentId)
    {
        return $this->setData(self::COMMENT_ID, $commentId);
    }

    public function getStatus()
    {
        return $this->_get(self::STATUS);
    }

    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    public function getEmail()
    {
        return $this->_get(self::EMAIL);
    }

    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    public function getPostId()
    {
        return $this->_get(self::POST_ID);
    }

    public function setPostId($postId)
    {
        return $this->setData(self::POST_ID, $postId);
    }

    public function getAuthor() {
        return $this->_get(self::AUTHOR);
    }

    public function setAuthor($author)
    {
        return $this->setData(self::AUTHOR, $author);
    }

    public function getContent() {
        return $this->_get(self::CONTENT);
    }

    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    public function getCreationTime() {
        return $this->_get(self::AUTHOR);
    }

    public function setCreationTime($creationTime)
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    public function getUpdateTime() {
        return $this->_get(self::UPDATE_TIME);
    }

    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }
}
