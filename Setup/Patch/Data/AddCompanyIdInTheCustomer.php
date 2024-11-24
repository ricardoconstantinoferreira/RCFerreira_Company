<?php

declare(strict_types=1);

namespace RCFerreira\Company\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Customer\Model\ResourceModel\Customer as ResourceModelCustomer;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

class AddCompanyIdInTheCustomer implements DataPatchInterface, PatchRevertableInterface
{

    public function __construct(
        private AttributeSet $attributeSet,
        private CustomerSetupFactory $customerSetupFactory,
        private ModuleDataSetupInterface $moduleDataSetup,
        private ResourceModelCustomer $resourceModelCustomer,
        private AttributeSetFactory $attributeSetFactory
    ) {}

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();

        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        $customerSetup->addAttribute(
            Customer::ENTITY,
            'company',
            [
                'type' => 'varchar',
                'label' => 'Company',
                'input' => 'select',
                'required' => false,
                'visible' => true,
                'user_defined' => true,
                'position' => 999,
                'system' => 0,
                'source' => 'RCFerreira\Company\Model\Config\Source\Options'
            ]
        );

        $attribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'company')
            ->addData([
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
                'used_in_forms' => ['adminhtml_customer']
            ]);

        $attribute->save();

        $this->moduleDataSetup->getConnection()->endSetup();

    }

    public function revert()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->removeAttribute(Customer::ENTITY, 'company');

        $this->moduleDataSetup->getConnection()->endSetup();
    }
}
