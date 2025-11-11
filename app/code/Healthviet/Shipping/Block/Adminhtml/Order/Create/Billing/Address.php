<?php

declare(strict_types=1);

namespace Healthviet\Shipping\Block\Adminhtml\Order\Create\Billing;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Model\Session\Quote;
use Magento\Customer\Api\AddressRepositoryInterface;
use Magento\Customer\Block\Adminhtml\Edit\Renderer\Region;
use Magento\Customer\Helper\Address as AddressHelper;
use Magento\Customer\Model\Address\Mapper;
use Magento\Customer\Model\Metadata\FormFactory as MetadataFormFactory;
use Magento\Customer\Model\Options;
use Magento\Directory\Helper\Data;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\View\LayoutInterface;
use Magento\Sales\Block\Adminhtml\Order\Create\Billing\Address as BillingAddress;
use Magento\Sales\Model\AdminOrder\Create;
use Healthviet\Shipping\Block\Adminhtml\Sales\Order\Address\Edit\Renderer\District;
use Healthviet\Shipping\Block\Adminhtml\Sales\Order\Address\Edit\Renderer\Ward;

class Address extends BillingAddress
{
    /**
     * @var LayoutInterface
     */
    protected $layout;

    /**
     * @param Context $context
     * @param Quote $sessionQuote
     * @param Create $orderCreate
     * @param PriceCurrencyInterface $priceCurrency
     * @param FormFactory $formFactory
     * @param DataObjectProcessor $dataObjectProcessor
     * @param Data $directoryHelper
     * @param EncoderInterface $jsonEncoder
     * @param MetadataFormFactory $customerFormFactory
     * @param Options $options
     * @param AddressHelper $addressHelper
     * @param AddressRepositoryInterface $addressService
     * @param SearchCriteriaBuilder $criteriaBuilder
     * @param FilterBuilder $filterBuilder
     * @param Mapper $addressMapper
     * @param LayoutInterface $layout
     * @param array $data
     */
    public function __construct(
        Context $context,
        Quote $sessionQuote,
        Create $orderCreate,
        PriceCurrencyInterface $priceCurrency,
        FormFactory $formFactory,
        DataObjectProcessor $dataObjectProcessor,
        Data $directoryHelper,
        EncoderInterface $jsonEncoder,
        MetadataFormFactory $customerFormFactory,
        Options $options,
        AddressHelper $addressHelper,
        AddressRepositoryInterface $addressService,
        SearchCriteriaBuilder $criteriaBuilder,
        FilterBuilder $filterBuilder,
        Mapper $addressMapper,
        LayoutInterface $layout,
        array $data = []
    ) {
        $this->layout = $layout;
        parent::__construct(
            $context,
            $sessionQuote,
            $orderCreate,
            $priceCurrency,
            $formFactory,
            $dataObjectProcessor,
            $directoryHelper,
            $jsonEncoder,
            $customerFormFactory,
            $options,
            $addressHelper,
            $addressService,
            $criteriaBuilder,
            $filterBuilder,
            $addressMapper,
            $data
        );
    }

    /**
     * Return array of additional form element renderers by element id
     *
     * @return array
     */
    protected function _getAdditionalFormElementRenderers(): array
    {
        $address = $this->getAddress();

        return [
            'region' => $this->layout->createBlock(
                Region::class
            ),
            'district' => $this->layout->createBlock(
                District::class
            ),
            'ward' => $this->layout->createBlock(
                Ward::class
            )->setWardId($address->getWardId() ?: '')
        ];
    }
}
