<?php
declare(strict_types=1);

namespace Healthviet\Directory\Model;

use Magento\Framework\Model\AbstractModel;
use Healthviet\Directory\Model\ResourceModel\Ward as ResourceModel;

class Ward extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'directory_district_ward_model';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
