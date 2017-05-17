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
class Magenico_MasterPassword_Helper_Log extends Mage_Core_Helper_Abstract
{

    /**
     * XML system configuration and filename for logging
     */
    const XML_CONFIG_LOGGING_ENABLED = "magenico_masterpassword/general/debug_enabled";
    const LOG_FILENAME = 'magenico_masterpassword.log';

    /**
     * boolean used to determine whether logging should be enabled
     * @var bool
     */
    private $debug;

    /**
     * constructor, initializes the $debug property
     */
    public function __construct()
    {
        $this->debug = Mage::getStoreConfig(self::XML_CONFIG_LOGGING_ENABLED);
    }

    /**
     * Logs messages with an optional user provided prefix to the log with filename specified above
     * in case of no prefix, the system generates it's own
     * @param string $message
     * $param string $prefix
     */
    public function log($message, $prefix = null)
    {
        if ($this->isEnabled()) {
            if (!is_string($message)) {
                $message = print_r($message, true);
            }
            if (!$prefix) {
                $prefix = $this->getLogPrefix();
            }
            Mage::log($prefix . $message, null, $this->getLogFilename());
        }
    }

    /**
     * Used to determine whether logging should be enabled, additional logic may be inserted if needed
     * @return bool
     */
    protected function isEnabled()
    {
        return $this->debug;
    }

    /**
     * Returns $filename which represents the filename of the log, can be changed
     * @return string
     */
    protected function getLogFilename()
    {
        return self::LOG_FILENAME;
    }

    /**
     * System generated prefix for a log entry in case user didn't provide one
     * @return string
     */
    protected function getLogPrefix()
    {
        return ucfirst(Mage::app()->getRequest()->getActionName()) . ': ';
    }
}
