<?php

declare(strict_types=1);

namespace RCFerreira\Company\Model;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use RCFerreira\Company\Api\CompanyRepositoryInterface;
use RCFerreira\Company\Api\Data\CompanyInterface;
use RCFerreira\Company\Model\ResourceModel\Company as CompanyResourceModel;
use RCFerreira\Company\Api\Data\CompanySearchResultsInterfaceFactory;
use RCFerreira\Company\Model\ResourceModel\Company\CollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function __construct(
        private CompanyResourceModel $companyResourceModel,
        private CompanyFactory $companyFactory,
        private CompanySearchResultsInterfaceFactory $companySearchResultsInterfaceFactory,
        private SearchCriteriaInterface $searchCriteria,
        private CollectionFactory $collectionFactory,
        private CollectionProcessorInterface $collectionProcessor
    ) {}

    /**
     * @param CompanyInterface $company
     * @return CompanyInterface
     * @throws CouldNotSaveException
     */
    public function save(CompanyInterface $company): CompanyInterface
    {
        try {
            $this->companyResourceModel->save($company);
            return $company;
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Error save company'));
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return array
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria): array
    {
        $items = [];
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->companySearchResultsInterfaceFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        $searchResults->setTotalCount($collection->getSize());

        if (!empty($searchResults->getItems())) {
            foreach ($searchResults->getItems() as $item) {
                $items[] = $item->getData();
            }
        }

        return $items;
    }

    /**
     * @param int $id
     * @return CompanyInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): CompanyInterface
    {
        $company = $this->companyFactory->create();
        $this->companyResourceModel->load($company, $id);

        if (!$company->getId()) {
            throw new NoSuchEntityException(__('Company %1 not found', $id));
        }

        return $company;
    }

    /**
     * @param CompanyInterface $company
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(CompanyInterface $company): bool
    {
        try {
            $this->companyResourceModel->delete($company);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }

        return true;
    }

    /**
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $id): bool
    {
        return $this->delete($this->getById($id));
    }
}
