<?php
declare(strict_types=1);

namespace Healthviet\Directory\Ui\Component\Listing\Column;

use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

abstract class AbstractActions extends Column
{
    /**
     * Primary field name
     *
     * @var string
     */
    const PRIMARY_FIELD = '';

    /**
     * Url path  to edit
     *
     * @var string
     */
    const URL_PATH_EDIT = '';
    /**
     * Url path  to delete
     *
     * @var string
     */
    const URL_PATH_DELETE = '';
    /**
     * URL builder
     *
     * @var UrlInterface
     */
    protected UrlInterface $urlBuilder;
    /**
     * @var Escaper
     */
    protected Escaper $escaper;

    /**
     * constructor
     *
     * @param UrlInterface $urlBuilder
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Escaper $escaper
     * @param array $components
     * @param array $data
     */
    public function __construct(
        UrlInterface $urlBuilder,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Escaper $escaper,
        array $components = [],
        array $data = []
    )
    {
        $this->urlBuilder = $urlBuilder;
        $this->escaper = $escaper;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item[static::PRIMARY_FIELD])) {
                    $title = $this->escaper->escapeHtmlAttr($item['default_name']);
                    $primaryField = static::PRIMARY_FIELD;
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_EDIT,
                                [
                                    $primaryField => $item[$primaryField]
                                ]
                            ),
                            'label' => __('Edit')
                        ],
                        'delete' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_DELETE,
                                [
                                    static::PRIMARY_FIELD => $item[$primaryField]
                                ]
                            ),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __("Delete %1", $title),
                                'message' => __("Are you sure you want to delete a %1 record?", $title)
                            ]
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }

}
