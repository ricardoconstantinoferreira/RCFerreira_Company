<?php

declare(strict_types=1);

namespace RCFerreira\Company\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action;
use RCFerreira\Company\Api\CompanyRepositoryInterface;

class Edit extends \Magento\Backend\App\Action implements HttpGetActionInterface
{

    const ADMIN_RESOURCE = 'RCFerreira_Company::save';

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     * @param CompanyRepositoryInterface $companyRepository
     */
    public function __construct(
        Action\Context $context,
        private \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        private \Magento\Framework\Registry $registry,
        private CompanyRepositoryInterface $companyRepository
    ) {
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('RCFerreira_Company::company_manage')
            ->addBreadcrumb(__('Company Price'), __('Company'))
            ->addBreadcrumb(__('Manage Company'), __('Manage Company'));

        return $resultPage;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = (int) $this->getRequest()->getParam('entity_id');
        $company = "";

        if ($id) {
            $company = $this->companyRepository->getById($id);
            if (!$company->getId()) {
                $this->messageManager->addErrorMessage(__('This Company no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Company') : __('New Company'),
            $id ? __('Edit Company') : __('New Company')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Pages'));

        $resultPage->getConfig()->getTitle()
            ->prepend((!empty($company)) ? $company->getRazaoSocial() : __('New Company'));

        return $resultPage;
    }
}
