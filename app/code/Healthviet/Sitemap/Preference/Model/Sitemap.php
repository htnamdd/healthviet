<?php

namespace Healthviet\Sitemap\Preference\Model;

use Magento\Sitemap\Model\SitemapItemInterface;

class Sitemap extends \Magento\Sitemap\Model\Sitemap
{
    /**
     * Generate XML file
     *
     * @see http://www.sitemaps.org/protocol.html
     *
     * @return $this
     */
    public function generateXml()
    {

        $this->_initSitemapItems();

        /** @var $item SitemapItemInterface */
        foreach ($this->_sitemapItems as $key => $items) {
            foreach ($items as $item) {
                $xml = $this->_getSitemapRow(
                    $item->getUrl(),
                    $item->getUpdatedAt(),
                    $item->getChangeFrequency(),
                    $item->getPriority(),
                    $item->getImages()
                );

                if ($this->_isSplitRequired($xml) && $this->_sitemapIncrement > 0) {
                    $this->_finalizeSitemap();
                }

                if (!$this->_fileSize) {
                    $this->_createSitemap();
                }

                $this->_writeSitemapRow($xml);
                // Increase counters
                $this->_lineCount++;
                $this->_fileSize += strlen($xml);
            }
            $this->_finalizeSitemap();
        }


        if ($this->_sitemapIncrement == 1) {
            // In case when only one increment file was created use it as default sitemap
            $sitemapPath = $this->getSitemapPath() !== null ? rtrim($this->getSitemapPath(), '/') : '';
            $path = $sitemapPath . '/' . $this->_getCurrentSitemapFilename($this->_sitemapIncrement);
            $destination = $sitemapPath . '/' . $this->getSitemapFilename();

            $this->_directory->renameFile($path, $destination);
        } else {
            // Otherwise create index file with list of generated sitemaps
            $this->_createSitemapIndex();
        }

        $this->setSitemapTime($this->_dateModel->gmtDate('Y-m-d H:i:s'));
        $this->save();

        return $this;
    }
}
