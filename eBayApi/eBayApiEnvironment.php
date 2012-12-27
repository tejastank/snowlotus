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
	// const app_mode = 'production';
	const app_mode = 'sandbox';

	var $ebay_config = array (
		'production' => array (
			'config' => 'config/ebay.config.php',
			'ru_name' => 'Philips-Philips81-c350--pkrqdtg',
			'sign_in_url' => 'https://signin.ebay.com/ws/eBayISAPI.dll?SignIn',
		),

		'sandbox' => array (
			'config' => 'config/ebay.config.sandbox.php',
			'ru_name' => 'Philips-Philips81-c350--pkrqdtg',
			'sign_in_url' => 'https://signin.sandbox.ebay.com/ws/eBayISAPI.dll?SignIn',
		),
	);

    public function __construct()
    {
		parent::__construct(0, $this->ebay_config[self::app_mode]['config']);
    }

    public function setup()
	{
		if ($this->session->getTokenMode() == 1) {
			if (!empty($_REQUEST['ebay_account_name'])) {
				$name = $_REQUEST['ebay_account_name'];
				$bean = BeanFactory::getBean('xeBayAccounts');
				if ($bean->retrieve_by_string_fields(array('name' => $name))) {
					$this->session->setRequestToken($bean->ebay_auth_token);
				}
			}
		}
	}

    public function init($logLevel = 0, $configFile)
    {
        if ($logLevel >= 1)
            $this->logger = new EbatNs_Logger();
        $this->configFile = $configFile;
        $this->session = new EbatNs_Session($this->configFile);
		$this->setup();
        $this->proxy = new EbatNs_ServiceProxy($this->session);
        
        if ($this->logger)
	        $this->proxy->attachLogger($this->logger);
    }

	public function appModeIsSandbox()
	{
		return (self::app_mode == 'sandbox');
	}

	public function getRuName()
	{
		return $this->ebay_config[self::app_mode]['ru_name'];
	}
	
	public function getSignInURL($session_id)
	{
		return $this->ebay_config[self::app_mode]['sign_in_url'] . "&RuName=" . $this->getRuname() . "&SessID=" . $session_id;
	}
}

?>
