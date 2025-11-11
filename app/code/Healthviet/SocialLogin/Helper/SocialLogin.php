<?php

namespace Healthviet\SocialLogin\Helper;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Config\Model\Config;
use Magento\Backend\App\ConfigInterface;

class SocialLogin extends AbstractHelper
{
    protected $_CreateAccountPathXML = 'healthviet/social_enabled_create_account/enabled';

    protected $_ModalPathXML = 'healthviet/social_enabled_modal/enabled';

    protected $_CheckoutPathXML = 'healthviet/social_enabled_checkout/enabled';


    /**
     * @var SessionFactory
     */
    protected $_customerSession;
    /**
     * @var CustomerFactory
     */
    protected $_customerFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;
    /**
     * @var ButtonConfig
     */
    protected $_buttonConfig;
    /**
     * @var Config
     */
    protected $_config;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $_customerRepository;

    /**
     * SocialLogin constructor.
     * @param Session $customerSession
     * @param CustomerFactory $customerFactory
     * @param StoreManagerInterface $storeManager
     * @param Config $buttonConfig
     * @param ConfigInterface $config
     * @param Context $context
     * @param CustomerRepositoryInterface $customerRepository
     */

    public function __construct(
        Session $customerSession,
        CustomerFactory $customerFactory,
        StoreManagerInterface $storeManager,
        Config $buttonConfig,
        ConfigInterface $config,
        Context $context,
        CustomerRepositoryInterface $customerRepository
    )
    {
        $this->_buttonConfig       = $buttonConfig;
        $this->_config             = $config;
        $this->_customerSession    = $customerSession;
        $this->_customerFactory    = $customerFactory;
        $this->_storeManager       = $storeManager;
        $this->_customerRepository = $customerRepository;
        parent::__construct($context);
    }

    /**
     * Login and save with customer email
     *
     * @param \Magento\Customer\Model\Customer $customer
     * @param array $data
     */
    public function login($customer, $data)
    {
        $customerRepo = $this->saveCustomerCustomerAttribute($customer, $data);
        if ($customerRepo) {
            $this->_customerSession->setCustomerDataAsLoggedIn($customerRepo);
            $this->_customerSession->regenerateId();
        }
    }

    /**
     * @param Customer $customer
     * @param $data
     * @return \Magento\Customer\Api\Data\CustomerInterface|null
     */
    public function saveCustomerCustomerAttribute(\Magento\Customer\Model\Customer $customer, $data)
    {
        try {
            $customerRepo = $this->_customerRepository->get($customer->getEmail());
            foreach ($data as $key => $datum) {
                $customerRepo->setCustomAttribute($key, $datum);
            }
            $this->_customerRepository->save($customerRepo);
            return $customerRepo;
        } catch (LocalizedException $e) {
            return null;
        }
    }

    /**
     * Create new Customer
     *
     * @param array $data
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function creatingAccount($data)
    {
        /** @var Customer $customer */
        $customer = $this->_customerFactory->create();
        $customer->setData($data);
        $customer->save();
        // fire create customer event successful
        $this->_eventManager->dispatch(
            'customer_register_success',
            ['account_controller' => $this, 'customer' => $customer->getDataModel()]
        );
        $customerRepo = $this->_customerRepository->get($customer->getEmail());
        if ($customerRepo) {
            $this->_customerSession->setCustomerDataAsLoggedIn($customerRepo);
            $this->_customerSession->regenerateId();
        }
    }

    /**
     * Get Customer by an attribute
     *
     * @param $id
     * @param $type
     * @return \Magento\Customer\Model\Customer
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCustomers($id, $type)
    {
        $customer = $this->_customerFactory->create()
            ->getResourceCollection()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('healthviet_sociallogin_id', $id)
            ->addAttributeToFilter('healthviet_sociallogin_type', $type)
            ->getFirstItem();
        return $customer;
    }

    /**
     * Get Customer By Email
     *
     * @param $email
     * @return \Magento\Customer\Model\Customer
     */
    public function getCustomerByEmail($email)
    {
        $websiteId = $this->_storeManager->getWebsite()->getId();
        $customer  = $this->_customerFactory->create()->setWebsiteId($websiteId)->loadByEmail($email);
        return $customer;
    }

    /**
     * @param $email
     * @return \Magento\Customer\Api\Data\CustomerInterface|null
     */
    public function getCustomerRepo($email)
    {
        try {
            return $this->_customerRepository->get($email);
        } catch (NoSuchEntityException $e) {
            return null;
        } catch (LocalizedException $e) {
            return null;
        }
    }

    /**
     * @return Bool
     */
    public function isLoggedIn()
    {
        return $this->_customerSession->isLoggedIn();
    }


    /**
     * @return Bool
     */
    public function isButtonEnabledCreateAccount()
    {
        return $this->_config->getValue($this->_CreateAccountPathXML);
    }

    /**
     * @return Bool
     */
    public function isButtonEnabledCheckout()
    {
        return (bool)$this->_config->getValue($this->_CheckoutPathXML);
    }

    /**
     * @return Bool
     */
    public function isButtonEnabledModal()
    {
        return (bool)$this->_config->getValue($this->_ModalPathXML);
    }

    /**
     * @return String
     */
    public function getTypeByEmail($email)
    {
        $customer = $this->getCustomerByEmail($email);
        return $customer['healthviet_sociallogin_type'];
    }
}
