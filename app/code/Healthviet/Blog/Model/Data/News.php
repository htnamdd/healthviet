<?php

namespace Healthviet\Blog\Model\Data;

class News extends \Magento\Framework\Api\AbstractSimpleObject implements \Healthviet\Blog\Api\Data\NewsInterface
{
    public function getPostId()
    {
        return $this->_get(self::POST_ID);
    }

    public function setPostId($postId)
    {
        return $this->setData(self::POST_ID, $postId);
    }

    public function getIdentifier()
    {
        return $this->_get(self::IDENTIFIER);
    }

    public function setIdentifier($identifier)
    {
        return $this->setData(self::IDENTIFIER, $identifier);
    }

    public function getTitle(){
        return $this->_get(self::TITLE);
    }

    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    public function getAuthor() {
        return $this->_get(self::AUTHOR);
    }

    public function setAuthor($author)
    {
        return $this->setData(self::AUTHOR, $author);
    }

    public function getTags() {
        return $this->_get(self::TAGS);
    }

    public function setTags($tags)
    {
        return $this->setData(self::TAGS, $tags);
    }

    public function getContent() {
        return $this->_get(self::CONTENT);
    }

    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    public function getShortContent() {
        return $this->_get(self::AUTHOR);
    }

    public function setShortContent($shortContent)
    {
        return $this->setData(self::SHORT_CONTENT, $shortContent);
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

    public function getImage() {
        return $this->_get(self::IMAGE);
    }

    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    public function getCommentsEnabled() {
        return $this->_get(self::COMMENTS_ENABLED);
    }

    public function setCommentsEnabled($commentsEnabled)
    {
        return $this->setData(self::COMMENTS_ENABLED, $commentsEnabled);
    }

    public function getComments()
    {
        return $this->_get(self::COMMENTS);
    }

    public function setComments(array $comments)
    {
        return $this->setData(self::COMMENTS, $comments);
    }
}
