<?php

declare(strict_types=1);

namespace RCFerreira\Company\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Customer\Model\SessionFactory;;
use RCFerreira\Company\Model\Company\CompanyData;

class Options extends AbstractSource
{

    private $session;

    /**
     * @param SessionFactory $sessionFactory
     * @param CompanyData $companyData
     */
    public function __construct(
        private SessionFactory $sessionFactory,
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

        $email = $this->session->getCompanyCustomerEmail();

        if (!empty($email)) {

            $dataCompany = $this->companyData->getCompanyByEmail($email);

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
        }

        return $optionDefault;
    }
}
