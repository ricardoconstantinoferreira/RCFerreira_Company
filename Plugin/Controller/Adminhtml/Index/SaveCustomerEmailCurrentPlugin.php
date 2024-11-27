<?php

declare(strict_types=1);

namespace RCFerreira\Company\Plugin\Controller\Adminhtml\Index;

use Magento\Customer\Model\SessionFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;

class SaveCustomerEmailCurrentPlugin
{
    /**
     * @param SessionFactory $sessionFactory
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        private SessionFactory $sessionFactory,
        private CustomerRepositoryInterface $customerRepository
    ) {}

    /**
     * @param \Magento\Customer\Controller\Adminhtml\Index\Edit $subject
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function beforeExecute(
        \Magento\Customer\Controller\Adminhtml\Index\Edit $subject
    ) {
        $sessionCustomer = $this->sessionFactory->create();
        $customerId = (int) $subject->getRequest()->getParam('id');

        if (!empty($customerId)) {
            $customer = $this->customerRepository->getById($customerId);
            $sessionCustomer->setCompanyCustomerEmail($customer->getEmail());
        }
    }
}
