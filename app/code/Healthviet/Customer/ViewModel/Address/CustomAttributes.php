<?php

declare(strict_types=1);

namespace Healthviet\Customer\ViewModel\Address;

use Magento\Framework\Api\AttributeInterface;
use Magento\Framework\App\Cache\Type\Config;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\ScopeInterface;
use Healthviet\Customer\Model\Source\District as DistrictSource;
use Healthviet\Customer\Model\Source\Ward as WardSource;

class CustomAttributes implements ArgumentInterface
{
    /**
     * @var Config
     */
    protected $configCacheType;

    /**
     * @var Json
     */
    protected $json;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var DistrictSource
     */
    protected $districtSource;

    /**
     * @var WardSource
     */
    protected $wardSource;

    /**
     * @var string
     */
    protected $districtJson;

    /**
     * @var string
     */
    protected $wardJson;

    /**
     * @param Config $configCacheType
     * @param Json $json
     * @param RequestInterface $request
     * @param DistrictSource $districtSource
     * @param WardSource $wardSource
     */
    public function __construct(
        Config $configCacheType,
        Json $json,
        RequestInterface $request,
        DistrictSource $districtSource,
        WardSource $wardSource
    ) {
        $this->configCacheType = $configCacheType;
        $this->json = $json;
        $this->request = $request;
        $this->districtSource = $districtSource;
        $this->wardSource = $wardSource;
    }

    /**
     * @param string $attributeCode
     * @param AttributeInterface[] $customAttributes
     * @return string
     */
    public function getCustomAttributeValue(string $attributeCode, array $customAttributes): string
    {
        $attributeValue = '';
        foreach ($customAttributes as $attribute) {
            if ($attribute->getAttributeCode() == $attributeCode) {
                $attributeValue = $attribute->getValue();
            }
        }

        return $attributeValue;
    }

    /**
     * @return string
     */
    public function getDistrictJson(): string
    {
        if (!$this->districtJson) {
            $scope = $this->getCurrentScope();
            $scopeKey = $scope['value'] ? '_' . implode('_', $scope) : null;
            $cacheKey = 'DIRECTORY_DISTRICTS_JSON_STORE' . $scopeKey;
            $json = $this->configCacheType->load($cacheKey);
            if (empty($json)) {
                $districts = $this->districtSource->toOptionArray();
                $json = $this->json->serialize($districts);
                $json = $json ?: '{}';

                $this->configCacheType->save($json, $cacheKey);
            }
            $this->districtJson = $json;
        }

        return $this->districtJson;
    }

    /**
     * @return string
     */
    public function getWardJson(): string
    {
        if (!$this->wardJson) {
            $scope = $this->getCurrentScope();
            $scopeKey = $scope['value'] ? '_' . implode('_', $scope) : null;
            $cacheKey = 'DIRECTORY_WARDS_JSON_STORE' . $scopeKey;
            $json = $this->configCacheType->load($cacheKey);
            if (empty($json)) {
                $wards = $this->wardSource->toOptionArray();
                $json = $this->json->serialize($wards);
                $json = $json ?: '{}';

                $this->configCacheType->save($json, $cacheKey);
            }
            $this->wardJson = $json;
        }

        return $this->wardJson;
    }

    /**
     * @return array
     */
    protected function getCurrentScope(): array
    {
        $scope = [
            'type' => ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            'value' => null,
        ];

        if ($this->request->getParam(ScopeInterface::SCOPE_WEBSITE)) {
            $scope = [
                'type' => ScopeInterface::SCOPE_WEBSITE,
                'value' => $this->request->getParam(ScopeInterface::SCOPE_WEBSITE),
            ];
        } elseif ($this->request->getParam(ScopeInterface::SCOPE_STORE)) {
            $scope = [
                'type' => ScopeInterface::SCOPE_STORE,
                'value' => $this->request->getParam(ScopeInterface::SCOPE_STORE),
            ];
        }

        return $scope;
    }
}
