<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Razoyo\AnimalProfile\Block\Profile;

class View extends \Magento\Framework\View\Element\Template
{
    /**
     * @var ScustomerSession
     */
    private $customerSession;

    protected $animals;

    protected $customerRepository;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context  $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Razoyo\AnimalProfile\Model\Animals\Source\Animals $animals,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->customerSession = $customerSession;
        $this->animals = $animals;
        $this->customerRepository = $customerRepository;
    }

    public function getGreeting()
    {
        return 'Hello ' . $this->customerSession->getCustomer()->getFirstname() . '!';
    }

    public function getPhotoUrl()
    {
        return $this->getUrl('animalid/profile/photo');
    }

    public function getAnimalOptions()
    {
        return $this->animals->toOptionArray();
    }

    public function getAnimalProfile(){
        $customer = $this->customerRepository->getById($this->customerSession->getId());
        if ($customer->getCustomAttribute('animal_profile')){
            return $customer->getCustomAttribute('animal_profile')->getValue();
        } else {
            return false;
        }
    }
}

