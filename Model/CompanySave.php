<?php

declare(strict_types=1);

namespace RCFerreira\Company\Model;

use RCFerreira\Company\Api\CompanySaveInterface;
use Magento\Framework\Webapi\Rest\Request;
use Magento\Framework\Serialize\Serializer\Json;
use RCFerreira\Company\Model\Company\CompanyData;
use RCFerreira\Company\Model\Customer\CustomerData;

class CompanySave implements CompanySaveInterface
{
    /**
     * @param Request $request
     * @param Json $json
     * @param CompanyData $companyData
     * @param CustomerData $customerData
     */
    public function __construct(
        private Request $request,
        private Json $json,
        private CompanyData $companyData,
        private CustomerData $customerData
    ) {}

    /**
     * @return string
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\State\InputMismatchException
     */
    public function execute(): string
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
}
