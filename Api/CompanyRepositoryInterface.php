<?php

declare(strict_types=1);

namespace RCFerreira\Company\Api;

use RCFerreira\Company\Api\Data\CompanyInterface;

interface CompanyRepositoryInterface
{
    /**
     * @param CompanyInterface $company
     * @return CompanyInterface
     */
    public function save(CompanyInterface $company): CompanyInterface;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return array
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria): array;

    /**
     * @param int $id
     * @return CompanyInterface
     */
    public function getById(int $id): CompanyInterface;

    /**
     * @param CompanyInterface $company
     * @return bool
     */
    public function delete(CompanyInterface $company): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;
}
