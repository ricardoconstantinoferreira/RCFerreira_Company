<?php

declare(strict_types=1);

namespace RCFerreira\Company\Plugin\Controller\Adminhtml\Index;

use Magento\Customer\Model\SessionFactory;

class SaveCustomerIdCurrentPlugin
{
    /**
     * @param SessionFactory $sessionFactory
     */
    public function __construct(
        private SessionFactory $sessionFactory
    ) {}

    /**
     * @param \Magento\Customer\Controller\Adminhtml\Index\Edit $subject
     * @return void
     */
    public function beforeExecute(
        \Magento\Customer\Controller\Adminhtml\Index\Edit $subject
    ) {
        $sessionCustomer = $this->sessionFactory->create();
        $customerId = (int) $subject->getRequest()->getParam('id');
        $sessionCustomer->setCompanyCustomerId($customerId);
    }
}
