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
		// parent::__construct(0, 'config/ebay.config.php');
		parent::__construct(0, 'config/ebay.config.sandbox.php');
    }

	public function getRuName()
	{
		return "Philips-Philips81-c350--pkrqdtg";
	}
	
	public function getSignInURL($session_id)
	{
		//return "https://signin.ebay.com/ws/eBayISAPI.dll?SignIn";
		return "https://signin.sandbox.ebay.com/ws/eBayISAPI.dll?SignIn" . "&RuName=" . $this->getRuname() . "&SessID=" . $session_id;
	}
}

?>
