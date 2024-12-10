<?php

declare(strict_types=1);

namespace RCFerreira\Company\Model\Customer;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;

class CustomerData
{
    /**
     * @param CustomerInterface $customer
     * @param CustomerRepositoryInterface $customerRepository
     * @param AccountManagementInterface $accountManagement
     */
    public function __construct(
        private CustomerInterface $customer,
        private CustomerRepositoryInterface $customerRepository,
        private AccountManagementInterface $accountManagement
    ) {}

    /**
     * @param array $data
     * @return int
     * @throws CouldNotSaveException
     */
    public function save(array $data): int
    {
        try {
            $password = $data['password'];
            $confirmation = $data['confirmation'];

            if ($password != $confirmation) {
                throw new InputException(__('Please make sure your passwords match.'));
            }

            $dataName = explode(" ", $data['razao_social']);
            $this->customer->setFirstname($dataName[0]);
            $this->customer->setLastname((isset($dataName[1])) ? $dataName[1] : "");
            $this->customer->setTaxvat($data['cnpj']);
            $this->customer->setEmail($data['email']);

            $customer = $this->accountManagement->createAccount($this->customer, $password, '');
            return (int)$customer->getId();

        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
    }

    /**
     * @param int $customerId
     * @param array $data
     * @return CustomerInterface
     * @throws InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\State\InputMismatchException
     */
    public function saveCustomAttributeCompany(int $customerId, array $data): CustomerInterface
    {
        $customer = $this->customerRepository->getById($customerId);
        $customer->setCustomAttribute('company', $data['entity_id']);

        return $this->customerRepository->save($customer);
    }
}
