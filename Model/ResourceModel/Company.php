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

    /**
     * @param int $companyId
     * @return array
     */
    public function fetchAllCustomersByCompanyId(int $companyId): array
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from("rcferreira_company", ["rcferreira_company.entity_id", "rcferreira_company.razao_social"])
            ->join("customer_entity_varchar", "customer_entity_varchar.value = rcferreira_company.entity_id", [])
            ->join("customer_entity", "customer_entity.entity_id = customer_entity_varchar.entity_id",
                ["customer_entity.entity_id as customer_id", "customer_entity.email", "customer_entity.firstname", "customer_entity.lastname"])
            ->where("rcferreira_company.entity_id = {$companyId} and customer_entity.email <> rcferreira_company.email");
        return $select->query()->fetchAll();
    }

    /**
     * @return array
     */
    public function fetchAllCompany(): array
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from("rcferreira_company");
        return $select->query()->fetchAll();
    }
}
