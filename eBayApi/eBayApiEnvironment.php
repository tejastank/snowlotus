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
    var $authentication_helper;
    var $sandbox_mode = true;
	var $app_mode = 0;
    var $site_id = 0;

    public function __construct()
    {
        global $sugar_config;
        $this->sandbox_mode = $sugar_config['ebay_app_mode_sandbox'];
        $this->app_mode = $this->sandbox_mode ? 1 : 0;
        $this->site_id = empty($sugar_config['ebay_primary_site_id']) ? 0 : $sugar_config['ebay_primary_site_id'];

		parent::__construct(0, 'config/ebay.config.php');
    }

    public function setup()
	{
	}

    public function init($logLevel = 0, $configFile)
    {
        if ($logLevel >= 1)
            $this->logger = new EbatNs_Logger();
        $this->configFile = $configFile;
        $this->session = new EbatNs_Session($this->configFile);
        $this->session->setAppMode($this->app_mode);
        $this->session->setSiteId($this->site_id);
		$this->setup();
        $this->proxy = new EbatNs_ServiceProxy($this->session);
        
        if ($this->logger)
	        $this->proxy->attachLogger($this->logger);
    }

	public function getSignInURL($sessionId)
	{
        require_once ('EbatNs_AuthenticationHelper.php');
        if (empty($this->authentication_helper))
            $this->authentication_helper = new EbatNs_AuthenticationHelper($this->proxy);
        return ($this->authentication_helper->GetEbaySignInUrl($this->session->getRuName()) . "&SessID={$sessionId}");
	}
}

?>
