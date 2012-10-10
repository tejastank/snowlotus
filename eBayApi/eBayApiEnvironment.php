<?php
/**
 * sources
 */
require_once 'setincludepath.php';
require_once 'EbatNs_Environment.php';

/**
 * Prepares an environment for testing ebatNs calls
 *
 */
class eBayApiEnvironment extends EbatNs_Environment
{
    public function __construct()
    {
		parent::__construct(0, 'config/ebay.config.php');
		// parent::__construct(0, 'config/ebay.config.sandbox.php');
    }
}

?>
