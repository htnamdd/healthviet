<?php


namespace Healthviet\Common\Model\Data;


use Healthviet\Common\Api\Data\OptionInterface;

class Option extends \Magento\Framework\Api\AbstractExtensibleObject implements OptionInterface
{
    /**
     * @return string
     */
    public function getValue()
    {
        return $this->_get(self::VALUE);
    }

    /**
     * @param string $value
     * @return Option
     */
    public function setValue($value)
    {
        return $this->setData(self::VALUE, $value);
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->_get(self::LABEL);
    }

    /**
     * @param string $label
     * @return Option
     */
    public function setLabel($label)
    {
        return $this->setData(self::LABEL, $label);
    }

}
