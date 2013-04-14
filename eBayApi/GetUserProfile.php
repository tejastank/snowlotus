<?php
/**
 * sources
 */
require_once 'eBayShoppingApi.php';
require_once 'GetUserProfileRequestType.php';

/**
 * sampleshopping_GetUserProfile
 * 
 * Sample call for GetUserProfile
 * 
 * @package ebatns
 * @subpackage samples_shopping
 * @author johann 
 * @copyright Copyright (c) 2008
 * @version $Id: sampleshopping_GetUserProfile.php,v 1.95 2012-09-10 11:14:11 michaelcoslar Exp $
 * @access public 
 */
class GetUserProfile extends eBayShoppingApi
{

    /**
     * sampleshopping_GetUserProfile::dispatchCall()
     * 
     * Dispatch the call
     *
     * @param array $params array of parameters for the eBay API call
     * 
     * @return boolean success
     */
	public function dispatchCall ($params)
    {
		$req = new GetUserProfileRequestType();
        $req->setUserID($params['UserID']);
		
        $res = $this->proxy->GetUserProfile($req);
        if ($this->testValid($res))
        {
            $this->dumpObject($res);
            return (true);
        }
        else 
        {
            return (false);
        }
    }
}

?>
