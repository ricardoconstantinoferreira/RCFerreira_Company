<?php

declare(strict_types=1);

namespace RCFerreira\Company\Model\ResourceModel\Company;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use RCFerreira\Company\Model\Company;
use RCFerreira\Company\Model\ResourceModel\Company as ResourceModelCompany;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(Company::class, ResourceModelCompany::class);
    }
}
