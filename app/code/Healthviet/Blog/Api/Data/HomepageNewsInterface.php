<?php

namespace Healthviet\Blog\Api\Data;

interface HomepageNewsInterface
{
    const STANDOUT_NEWS = 'standout_news';
    const OTHER_NEWS = 'other_news';

    /**
     * @return  \Healthviet\Blog\Api\Data\NewsInterface[]
     */
    public function getStandoutNews();

    /**
     * @param \Healthviet\Blog\Api\Data\NewsInterface[] $standoutNews
     * @return $this
     */
    public function setStandoutNews(array $standoutNews);

    /**
     * @return  \Healthviet\Blog\Api\Data\NewsInterface[]
     */
    public function getOtherNews();

    /**
     * @param \Healthviet\Blog\Api\Data\NewsInterface[] $otherNews
     * @return $this
     */
    public function setOtherNews(array $otherNews);
}
