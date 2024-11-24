<?php

declare(strict_types=1);

namespace RCFerreira\Company\Api;

interface CompanySaveInterface
{

    /**
     * @api
     *
     * @return string
     */
    public function execute(): string;
}
