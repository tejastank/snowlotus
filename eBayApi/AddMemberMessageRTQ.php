<?php
/**
 * sources
 */
require_once 'eBayTradingApi.php';
require_once 'AddMemberMessageRTQRequestType.php';

/**
 * sample_AddMemberMessageAAQToPartner
 * 
 * Sample call for AddMemberMessageAAQToPartner
 * 
 * @package ebatns
 * @subpackage samples_trading
 * @author johann 
 * @copyright Copyright (c) 2008
 * @version $Id: sample_AddMemberMessageAAQToPartner.php,v 1.107 2012-09-10 11:01:19 michaelcoslar Exp $
 * @access public 
 */
class AddMemberMessageRTQ extends eBayTradingApi
{

    /**
     * sample_AddMemberMessageAAQToPartner::dispatchCall()
     * 
     * Dispatch the call
     *
     * @param array $params array of parameters for the eBay API call
     * 
     * @return boolean success
     */
    public function dispatchCall ($params)
    {
        $req = new AddMemberMessageRTQRequestType();
        $req->setItemID($params['ItemID']);
        
        $MemberMessage = new MemberMessageType();
        $MemberMessage->setBody($params['Body']);
        $MemberMessage->setParentMessageID($params['ParentMessageID']);
        $MemberMessage->setRecipientID($params['RecipientID']);
        
        $req->setMemberMessage($MemberMessage);
        
        $res = $this->proxy->AddMemberMessageRTQ($req);
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

	public function addMemberMessage($params)
	{
		$this->session->setRequestToken($params['AuthToken']);

        $req = new AddMemberMessageRTQRequestType();
        $req->setItemID($params['ItemID']);
        
        $MemberMessage = new MemberMessageType();
        $MemberMessage->setBody($params['Body']);
        $MemberMessage->setParentMessageID($params['ParentMessageID']);
        $MemberMessage->setRecipientID($params['RecipientID']);
        
        $req->setMemberMessage($MemberMessage);
        
        $res = $this->proxy->AddMemberMessageRTQ($req);
        if ($this->testValid($res)) {
            return true;
        } else {
            $this->dumpObject($res);
            return false;
        }
	}
}

?>
