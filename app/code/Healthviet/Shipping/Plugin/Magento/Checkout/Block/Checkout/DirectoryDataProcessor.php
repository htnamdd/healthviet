<?php

declare(strict_types=1);

namespace Healthviet\Shipping\Plugin\Magento\Checkout\Block\Checkout;

use Magento\Checkout\Block\Checkout\DirectoryDataProcessor as BaseDirectoryDataProcessor;
use Healthviet\Shipping\Model\Source\District;
use Healthviet\Shipping\Model\Source\Ward;

class DirectoryDataProcessor
{
    /**
     * @var District
     */
    protected $district;

    /**
     * @var Ward
     */
    protected $ward;

    /**
     * @var array
     */
    protected $districtOptions;

    /**
     * @var array
     */
    protected $wardOptions;

    /**
     * @param District $district
     * @param Ward $ward
     */
    public function __construct(
        District $district,
        Ward $ward
    ) {
        $this->district = $district;
        $this->ward = $ward;
    }

    /**
     * @param BaseDirectoryDataProcessor $processor
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(BaseDirectoryDataProcessor $processor, array $jsLayout): array
    {
        if (isset($jsLayout['components']['checkoutProvider']['dictionaries'])) {
            $jsLayout['components']['checkoutProvider']['dictionaries']['district_id'] = $this->getDistrictOptions();
            $jsLayout['components']['checkoutProvider']['dictionaries']['ward_id'] = $this->getWardOptions();
        }

        return $jsLayout;
    }

    /**
     * @return array
     */
    protected function getDistrictOptions(): array
    {
        if (!isset($this->districtOptions)) {
            $this->districtOptions = $this->district->toOptionArray();
        }

        return $this->districtOptions;
    }

    /**
     * @return array
     */
    protected function getWardOptions()
    {
        if (!isset($this->wardOptions)) {
            $this->wardOptions = $this->ward->toOptionArray();
        }

        return $this->wardOptions;
    }
}
