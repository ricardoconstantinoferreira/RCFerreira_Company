<?php

declare(strict_types=1);

namespace RCFerreira\Company\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use RCFerreira\Company\Api\CompanyRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Customer\Model\SessionFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use RCFerreira\Company\Model\Company\CompanyData;

class Options extends AbstractSource
{

    private $session;

    /**
     * @param CompanyRepositoryInterface $companyRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SessionFactory $sessionFactory
     */
    public function __construct(
        private CompanyRepositoryInterface $companyRepository,
        private SearchCriteriaBuilder $searchCriteriaBuilder,
        private SessionFactory $sessionFactory,
        private CustomerRepositoryInterface $customerRepository,
        private CompanyData $companyData
    ) {
        $this->session = $this->sessionFactory->create();
    }

    /**
     * @return array|array[]|null
     */
    public function getAllOptions()
    {
        $optionDefault = [
            ['label' => 'Selecione', 'value' => '']
        ];

        $customerId = $this->session->getCompanyCustomerId();
        $customer = $this->customerRepository->getById($customerId);

        $dataCompany = $this->companyData->getCompanyByEmail($customer->getEmail());

        if (empty($dataCompany)) {
            $dataCompany = $this->companyData->getAllCompany();
        }
        
        if (!empty($dataCompany)) {
            foreach ($dataCompany as $data) {
                $this->_options[] = [
                    'label' => $data['razao_social'],
                    'value' => $data['entity_id']
                ];
            }

            return array_merge($optionDefault, $this->_options);
        }

        return $optionDefault;
    }
}
