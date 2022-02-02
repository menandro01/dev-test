<?php
namespace Razoyo\AnimalProfile\Setup\Patch\Data;


use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Config;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Setup\CustomerSetupFactory;

class AddAnimalProfileAttribute implements \Magento\Framework\Setup\Patch\DataPatchInterface
{
    private $moduleDataSetup;
    private $customerSetupFactory;
    private $eavConfig;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        Config $eavConfig
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->eavConfig = $eavConfig;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $customerSetup->addAttribute(Customer::ENTITY, 'animal_profile', [
            'type' => 'varchar',
            'label' => 'Animal Profile',
            'input' => 'text',
            'sort_order' => 100,
            'position' => 100,
            'required' => false,
            'visible' => true,
            'system' => false
        ]);

        $animalProfile = $this->eavConfig->getAttribute(Customer::ENTITY, 'animal_profile');

        $animalProfile->setData(
            'used_in_forms',
            ['adminhtml_customer']
        );
        $animalProfile->save();
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}
