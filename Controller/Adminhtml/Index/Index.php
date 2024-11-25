<?php

declare(strict_types=1);

namespace RCFerreira\Company\Controller\Adminhtml\Index;

use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action\Context;

class Index extends \Magento\Backend\App\Action
{
    public const ADMIN_RESOURCE = 'RCFerreira_Company::company_manage';

    /**
     * @param PageFactory $resultPageFactory
     * @param Context $context
     */
    public function __construct(
        private PageFactory $resultPageFactory,
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Listing Company')));
        return $resultPage;
    }
}
