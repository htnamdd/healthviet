<?php

namespace Healthviet\Catalog\Preference\Model;

class Product extends \Magento\Catalog\Model\Product
{
    public function getDiscountPercent()
    {
        $simplePrice = $this->getTypeId() === 'simple' ? $this->getPrice() : $this->getChildProductPrice();

        $finalPrice = $this->getFinalPrice();
        if ($finalPrice < $simplePrice) {
            $savingPercent = 100 - round(($finalPrice / $simplePrice) * 100);
            return '-' . $savingPercent . '%';
        }

        return 0;
    }

    private function getChildProductPrice()
    {
        $_children = $this->getTypeInstance()->getUsedProducts($this);
        foreach ($_children as $child) {
            return $child->getPrice();
        }

        return 0;
    }
}
