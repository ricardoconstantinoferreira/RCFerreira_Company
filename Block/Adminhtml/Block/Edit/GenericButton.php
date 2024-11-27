<?php

declare(strict_types=1);

namespace RCFerreira\Company\Block\Adminhtml\Block\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use RCFerreira\Company\Api\CompanyRepositoryInterface;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @param Context $context
     * @param CompanyRepositoryInterface $companyRepository
     */
    public function __construct(
        private Context $context,
        private CompanyRepositoryInterface $companyRepository
    ) {}

    /**
     * @return mixed|null
     */
    public function getEntityId()
    {
        try {
            return $this->companyRepository->getById(
                (int) $this->context->getRequest()->getParam('entity_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * @param $route
     * @param $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
