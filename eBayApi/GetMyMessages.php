<?php
/**
 * sources
 */
require_once 'eBayApiEnvironment.php';
require_once 'GetMyMessagesRequestType.php';

/**
 * sample_GetMyMessagess
 * 
 * Sample call for GetMyMessagess
 * 
 * @package ebatns
 * @subpackage samples_trading
 * @author johann 
 * @copyright Copyright (c) 2008
 * @version $Id: sample_GetMyMessagess.php,v 1.107 2012-09-10 11:01:21 michaelcoslar Exp $
 * @access public
 */
class GetMyMessages extends eBayApiEnvironment
{

   /**
     * sample_GetMyMessages::dispatchCall()
     * 
     * Dispatch the call
     *
     * @param array $params array of parameters for the eBay API call
     * 
     * @return boolean success
     */
    public function dispatchCall ($params)
    {
        $req = new GetMyMessagesRequestType();
        $req->setDetailLevel($params['DetailLevel']);

        $messageIDs = new MyMessagesMessageIDArrayType();
        $messageIDs->setMessageID($params['MessageID']);
        $req->setMessageIDs($messageIDs);
        
        $res = $this->proxy->GetMyMessages($req);
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

	public function fill_my_messages($res)
	{
		$xmlString = "<?xml version='1.0' standalone='yes'?><MyMessages></MyMessages>";
		$xml = simplexml_load_string($xmlString);
		$xmlSub = $xml->addChild('Summary');

		$folderSummaries = $res->getSummary()->getFolderSummary();
		if (!empty($folderSummaries)) {
			foreach($folderSummaries as &$folderSummary) {
				$child = $xmlSub->addChild('FolderSummary');
				$folderID = $folderSummary->getFolderID();
				$child->addChild('FolderID', $folderID);
				$folderName = '';
				switch($folderID) {
				case '0':
					$folderName = 'Inbox';
					break;
				case '1':
					$folderName = 'Sent';
					break;
				default:
					$folderName = $folderSummary->getFolderName();
					if (empty($folderName))
						$folderName = "Folder {$folderID}";
					break;
				}
				$child->addChild('FolderName', $folderName);
				$child->addChild('NewAlertCount', $folderSummary->getNewAlertCount());
				$child->addChild('NewHighPriorityCount', $folderSummary->getNewHighPriorityCount());
				$child->addChild('NewMessageCount', $folderSummary->getNewMessageCount());
				$child->addChild('TotalAlertCount', $folderSummary->getTotalAlertCount());
				$child->addChild('TotalHighPriorityCount', $folderSummary->getTotalHighPriorityCount());
				$child->addChild('TotalMessageCount', $folderSummary->getTotalMessageCount());
			}
		}

        return htmlentities($xml->asXML(), ENT_QUOTES, 'UTF-8');
	}

	public function retrieveMyMessages($params)
	{
		$account_id = $params['AccountID'];
		$this->session->setRequestToken($params['AuthToken']);

		$detailLevel = $params['DetailLevel'];

        $req = new GetMyMessagesRequestType();
        $req->setDetailLevel($detailLevel);
		$req->setStartTime($params['StartTime']);
		$req->setEndTime($params['EndTime']);

        $res = $this->proxy->GetMyMessages($req);
        if ($this->testValid($res)) {
            $this->dumpObject($res);
			if ($detailLevel == 'ReturnSummary') {
				$account = BeanFactory::getBean('xeBayAccounts', $account_id);
				if ($account == false)
					return false;
				$account->my_messages_summary = $this->fill_my_messages($res);
				$account->save();
			} else {
			}
            return (true);
        } else {
            $this->dumpObject($res);
            return (false);
        }
	}
}

?>
