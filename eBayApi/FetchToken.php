<?php
/**
 * sources
 */
require_once 'eBayApiEnvironment.php';
require_once 'FetchTokenRequestType.php';

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
class FetchToken extends eBayApiEnvironment
{
   /**
     * sample_FetchToken::dispatchCall()
     * 
     * Dispatch the call
     *
     * @param array $params array of parameters for the eBay API call
     * 
     * @return boolean success
     */
	public function dispatchCall ($params)
    {
        $req = new FetchTokenRequestType();
        $req->setSessionID($params['SessionID']);
        
        $res = $this->proxy->FetchToken($req);
        if ($this->testValid($res))
        {
			return array (
				'AuthToken' => $res->getEBayAuthToken(),
				'ExpireTime' => $res->getHardExpirationTime(),
			);
        }
        else 
        {
            $this->dumpObject($res);
            return (false);
        }
    }
}

?>
