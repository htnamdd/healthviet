<?php

declare(strict_types=1);

namespace Healthviet\PriceDecimal\Model\Plugin;

use Healthviet\PriceDecimal\Model\ConfigInterface;
use Healthviet\PriceDecimal\Model\PricePrecisionConfigTrait;

abstract class PriceFormatPluginAbstract
{
    use PricePrecisionConfigTrait;

    /** @var ConfigInterface  */
    protected $moduleConfig;

    /**
     * @param \Healthviet\PriceDecimal\Model\ConfigInterface $moduleConfig
     */
    public function __construct(
        ConfigInterface $moduleConfig
    ) {
        $this->moduleConfig  = $moduleConfig;
    }
}
