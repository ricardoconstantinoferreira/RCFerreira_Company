<?php

declare(strict_types=1);

namespace RCFerreira\Company\Api;

interface CompanyApiInterface
{

    /**
     * @api
     *
     * @return string
     */
    public function saveCompany(): string;

    /**
     * @api
     *
     * @return array
     */
    public function getAllCompany(): array;

    /**
     * @api
     *
     * @return array
     */
    public function getCustomersByCompanyId(): array;
}
