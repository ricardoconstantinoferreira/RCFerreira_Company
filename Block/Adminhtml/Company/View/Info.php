<?php

declare(strict_types=1);

namespace RCFerreira\Company\Block\Adminhtml\Company\View;

use RCFerreira\Company\Model\ResourceModel\Company;

class Info extends \Magento\Framework\View\Element\Template
{

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param Company $company
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        private Company $company,
        array $data = []
    ){
        parent::__construct($context, $data);
    }

    /**
     * @return array
     */
    public function getInformationCustomerByCompany(int $companyId): array
    {
        return $this->company->fetchAllCustomersByCompanyId($companyId);
    }
}
