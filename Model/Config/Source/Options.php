<?php

declare(strict_types=1);

namespace RCFerreira\Company\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Customer\Model\SessionFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use RCFerreira\Company\Model\Company\CompanyData;

class Options extends AbstractSource
{

    private $session;

    /**
     * @param SessionFactory $sessionFactory
     * @param CustomerRepositoryInterface $customerRepository
     * @param CompanyData $companyData
     */
    public function __construct(
        private SessionFactory $sessionFactory,
        private CustomerRepositoryInterface $customerRepository,
        private CompanyData $companyData
    ) {
        $this->session = $this->sessionFactory->create();
    }

    /**
     * @return array|array[]|null
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
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
