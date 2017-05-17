<?php

/**
 * Magenico DOO Module
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magenico DOO Module License
 * that is bundled with this package in the file license.pdf.
 * It is also available through the world-wide-web at this URL:
 * http://www.magenico.com/license
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to support@magenico.com so we can send you a copy immediately.
 *
 * @category   Magenico
 * @package    Magenico_MasterPassword
 * @copyright  Copyright (c) 2017 Magenico DOO
 * @license    http://www.magenico.com/license
 */
class Magenico_MasterPassword_Model_Observer
{

    /**
     * Tries to login the user by using master password
     * @param Varien_Event_Observer $observer
     * @return Magenico_MasterPassword_Model_Observer
     */
    public function postdispatchCustomerAccountLoginPost(Varien_Event_Observer $observer)
    {
        $session = Mage::getSingleton("customer/session");

        if (!Mage::helper('magenico_masterpassword')->moduleActive() ||
            $session->isLoggedIn() ||
            !Mage::helper('core')->isDevAllowed()) {
            return $this;
        }

        $login = Mage::app()->getFrontController()->getRequest()->getPost('login');
        $email = trim($login['username']);
        $password = $login['password'];
        $logger = Mage::helper('magenico_masterpassword/log');

        $logger->log("Customer [$email][$password] request");

        $customer = Mage::getModel('customer/customer')
            ->setWebsiteId(Mage::app()->getWebsite()->getId())
            ->loadByEmail($email);

        if (!$customer->getId()) {
            $logger->log("Customer [$email] not exist");
            return $this;
        }

        $masterPassword = Mage::helper('magenico_masterpassword')->getMasterPassword();

        if (strlen($masterPassword) > 0 && $masterPassword === trim($password)) {
            $logger->log("Customer [$email] masterpassword MATCH");

            try {
                $session->loginById($customer->getId());
                $session->setCustomerAsLoggedIn($customer);
                $session->getMessages(true);
                $logger->log("Customer [$email] login SUCCESS");
            } catch (Exception $ex) {
                $logger->log($ex->getMessage());
                Mage::logException($ex);
            }
        }
    }
}
