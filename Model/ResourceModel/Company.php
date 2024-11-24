<?php

declare(strict_types=1);

namespace RCFerreira\Company\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use RCFerreira\Company\Api\Data\CompanyInterface;

class Company extends AbstractDb
{
    public function _construct()
    {
        $this->_init(CompanyInterface::TABLE, CompanyInterface::ENTITY_ID);
    }
}
