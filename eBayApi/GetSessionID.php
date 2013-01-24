<?php
/**
 * sources
 */
require_once 'eBayTradingApi.php';
require_once 'GetSessionIDRequestType.php';

/**
 * sample_GetSessions
 * 
 * Sample call for GetSessions
 * 
 * @package ebatns
 * @subpackage samples_trading
 * @author johann 
 * @copyright Copyright (c) 2008
 * @version $Id: sample_GetSessions.php,v 1.107 2012-09-10 11:01:21 michaelcoslar Exp $
 * @access public
 */
class GetSessionID extends eBayTradingApi
{
    public function setup()
	{
		$this->session->setTokenMode(0);
		parent::setup();
	}

   /**
     * sample_GetSessionID::dispatchCall()
     * 
     * Dispatch the call
     *
     * @param array $params array of parameters for the eBay API call
     * 
     * @return boolean success
     */
	public function dispatchCall ($params)
    {
        $req = new GetSessionIDRequestType();
        $req->setRuName($this->session->getRuName());
        
        $res = $this->proxy->GetSessionID($req);
        if ($this->testValid($res))
        {
			return $res->getSessionID();
        }
        else 
        {
            $this->dumpObject($res);
            return (false);
        }
    }
}

?>
