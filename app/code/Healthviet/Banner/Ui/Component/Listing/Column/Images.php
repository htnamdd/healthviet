<?php
/**
 * Created by PhpStorm.
 * User: fzenky
 * Date: 09/01/2019
 * Time: 22:14
 */

namespace Healthviet\Banner\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;

class Images extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * object of store manger class
     * @var storemanager
     */
    protected $_storeManager;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param StoreManagerInterface $storemanager
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StoreManagerInterface $storemanager,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->_storeManager = $storemanager;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        $path = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['image'])) {
                    $item[$fieldName] = "<div style='width: 300px '>" .
                        "<img src=" . $path . $item['image'] . " style='display:inline-block;margin:2px;width:100px !important;height:50px !important;'/>";
                }
            }
        }
        return $dataSource;
    }
}
