<?php
/**
 * sources
 */
require_once 'eBayTradingApi.php';
require_once 'GetUserRequestType.php';

/**
 * sample_GetUser
 * 
 * Sample call for GetUser
 * 
 * @package ebatns
 * @subpackage samples_trading
 * @author johann 
 * @copyright Copyright (c) 2008
 * @version $Id: sample_GetUser.php,v 1.107 2012-09-10 11:01:21 michaelcoslar Exp $
 * @access public
 */
class GetUser extends eBayTradingApi
{

   /**
     * sample_GetUser::dispatchCall()
     * 
     * Dispatch the call
     *
     * @param array $params array of parameters for the eBay API call
     * 
     * @return boolean success
     */
    public function dispatchCall ($params)
    {
		$this->session->setRequestToken($params['AuthToken']);

        $req = new GetUserRequestType();
        $req->setUserID($params['UserID']);
		
        $res = $this->proxy->GetUser($req);
        if ($this->testValid($res))
        {
			$user = $res->getUser();
			$res = array();
			$res['FeedbackScore'] = $user->getFeedbackScore();
			$res['FeedbackRatingStar'] = $user->getFeedbackRatingStar();
			$res['RegistrationDate'] = $user->getRegistrationDate();
			$res['StoreURL'] = $user->getSellerInfo()->getStoreURL();

            return $res;
        }
        else 
        {
            $this->dumpObject($res);
            return (false);
        }
    }
}

?>
