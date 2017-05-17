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
class Magenico_MasterPassword_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * Module magento system configuration paths
     */
    const XML_CONFIG_FIELD_ENABLED = "magenico_masterpassword/general/active";
    const XML_CONFIG_FIELD_MASTERPASSWORD = "magenico_masterpassword/general/master_password";

    /**
     * Returns magento store configuration for given path
     * @param string $path
     * @return string
     */
    protected function getStoreConfig($path)
    {
        return Mage::getStoreConfig($path, Mage::app()->getStore());
    }

    /**
     * Returns whether the module is active
     * @return bool
     */
    public function moduleActive()
    {
        return (bool) ($this->getStoreConfig(self::XML_CONFIG_FIELD_ENABLED) == 1);
    }

    /**
     * Returns master password in string format
     * @return string
     */
    public function getMasterPassword()
    {
        return $this->getStoreConfig(self::XML_CONFIG_FIELD_MASTERPASSWORD);
    }
}
