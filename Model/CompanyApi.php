<?php

declare(strict_types=1);

namespace RCFerreira\Company\Model;

use RCFerreira\Company\Api\CompanyApiInterface;
use Magento\Framework\Webapi\Rest\Request;
use Magento\Framework\Serialize\Serializer\Json;
use RCFerreira\Company\Model\Company\CompanyData;
use RCFerreira\Company\Model\Customer\CustomerData;
use RCFerreira\Company\Model\ResourceModel\Company as CompanyResourceModel;

class CompanyApi implements CompanyApiInterface
{
    /**
     * @param Request $request
     * @param Json $json
     * @param CompanyData $companyData
     * @param CustomerData $customerData
     * @param CompanyResourceModel $company
     */
    public function __construct(
        private Request $request,
        private Json $json,
        private CompanyData $companyData,
        private CustomerData $customerData,
        private CompanyResourceModel $company
    ) {}

    /**
     * @return string
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\State\InputMismatchException
     */
    public function saveCompany(): string
    {
        $result = [];

        $data = $this->request->getBodyParams();

        $customerId = $this->customerData->save($data);
        if ($customerId) {
            $result = $this->companyData->save($data);
            $this->customerData->saveCustomAttributeCompany($customerId, $result);
        }

        return $this->json->serialize($result);
    }

    /**
     * @return array
     */
    public function getAllCompany(): array
    {
        return $this->companyData->getAllCompany();
    }

    public function getCustomersByCompanyId(): array
    {
        return $this->company->fetchAllCustomersByCompanyId((int) $this->request->getParam("id"));
    }
}
