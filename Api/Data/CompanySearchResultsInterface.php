<?php

declare(strict_types=1);

namespace RCFerreira\Company\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface CompanySearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \Magento\Framework\Api\ExtensibleDataInterface[]
     */
    public function getItems();

    /**
     * @param array $items
     * @return mixed
     */
    public function setItems(array $items);
}
