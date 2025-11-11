<?php

namespace Healthviet\Blog\Model\Data;

class HomepageNews extends \Magento\Framework\Api\AbstractSimpleObject implements \Healthviet\Blog\Api\Data\HomepageNewsInterface
{
    /**
     * @return \Healthviet\Blog\Api\Data\NewsInterface[]
     */
    public function getStandoutNews()
    {
        $standoutNews = $this->_get(self::STANDOUT_NEWS);
        return is_array($standoutNews) ? $standoutNews : [];
    }

    /**
     * @param \Healthviet\Blog\Api\Data\NewsInterface[] $standoutNews
     * @return HomepageNews
     */
    public function setStandoutNews(array $standoutNews)
    {
        return $this->setData(self::STANDOUT_NEWS, $standoutNews);
    }

    /**
     * @return \Healthviet\Blog\Api\Data\NewsInterface[]
     */
    public function getOtherNews()
    {
        $otherNews = $this->_get(self::OTHER_NEWS);
        return is_array($otherNews) ? $otherNews : [];
    }

    /**
     * @param \Healthviet\Blog\Api\Data\NewsInterface[] $otherNews
     * @return HomepageNews
     */
    public function setOtherNews(array $otherNews)
    {
        return $this->setData(self::OTHER_NEWS, $otherNews);
    }
}
