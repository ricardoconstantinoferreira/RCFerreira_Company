<?php

declare(strict_types=1);

namespace RCFerreira\Company\Model\Company;

use Magento\Framework\Exception\CouldNotSaveException;
use RCFerreira\Company\Api\CompanyRepositoryInterface;
use RCFerreira\Company\Api\Data\CompanyInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class CompanyData
{
    /**
     * @param CompanyInterface $company
     * @param CompanyRepositoryInterface $companyRepository
     */
    public function __construct(
        private CompanyInterface $company,
        private CompanyRepositoryInterface $companyRepository,
        private SearchCriteriaBuilder $searchCriteriaBuilder
    ) {}

    /**
     * @param array $data
     * @return array
     * @throws CouldNotSaveException
     */
    public function save(array $data): array
    {
        try {
            $this->company->setCnpj($data['cnpj']);
            $this->company->setRazaoSocial($data['razao_social']);
            $this->company->setNomeFantasia($data['nome_fantasia']);
            $this->company->setEmail($data['email']);
            $this->company->setMei($data['mei']);
            $this->company->setSimples($data['simples']);

            $dataCompany = $this->companyRepository->save($this->company);

            return $dataCompany->getData();
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
    }

    /**
     * @param string $email
     * @return array
     */
    public function getCompanyByEmail(string $email): array
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('email', $email)
            ->create();
        return $this->companyRepository->getList($searchCriteria);
    }

    /**
     * @return array
     */
    public function getAllCompany(): array
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();
        return $this->companyRepository->getList($searchCriteria);
    }
}
