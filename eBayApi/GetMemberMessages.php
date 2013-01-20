<?php
/**
 * sources
 */
require_once 'eBayApiEnvironment.php';
require_once 'GetMemberMessagesRequestType.php';

/**
 * sample_GetMemberMessagess
 * 
 * Sample call for GetMemberMessagess
 * 
 * @package ebatns
 * @subpackage samples_trading
 * @author johann 
 * @copyright Copyright (c) 2008
 * @version $Id: sample_GetMemberMessagess.php,v 1.107 2012-09-10 11:01:21 michaelcoslar Exp $
 * @access public
 */
class GetMemberMessages extends eBayApiEnvironment
{

   /**
     * sample_GetMemberMessages::dispatchCall()
     * 
     * Dispatch the call
     *
     * @param array $params array of parameters for the eBay API call
     * 
     * @return boolean success
     */
    public function dispatchCall ($params)
    {
        $req = new GetMemberMessagesRequestType();
        $req->setMailMessageType($params['MailMessageType']);
        
        $pagination = new PaginationType();
        $pagination->setEntriesPerPage($params['pagination']['EntriesPerPage']);
        $pagination->setPageNumber($params['pagination']['PageNumber']);
        $req->setPagination($pagination);
        
        $res = $this->proxy->GetMemberMessages($req);
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

	function getResponsesXml($responses)
	{
		$xmlString = "<?xml version='1.0' standalone='yes'?><MemberMessages></MemberMessages>";
		$xml = simplexml_load_string($xmlString);
		$xmlSub = $xml->addChild('Responses');

		if (!empty($responses)) {
			foreach($responses as &$response) {
				$child = $xmlSub->addChild('Response', $response);
			}
		}

        return htmlentities($xml->asXML(), ENT_QUOTES, 'UTF-8');
	}

	public function retrieveMemberMessages($params)
	{
		$bean = BeanFactory::getBean('xeBayMessages');

		$account_id = $params['AccountID'];
		$this->session->setRequestToken($params['AuthToken']);

        $req = new GetMemberMessagesRequestType();
        $req->setMailMessageType($params['MailMessageType']);
		// $req->setStartCreationTime($params['StartCreationTime']);
		// $req->setEndCreationTime($params['EndCreationTime']);

        $pagination = new PaginationType();
        $pagination->setEntriesPerPage($params['pagination']['EntriesPerPage']);
        $pagination->setPageNumber($params['pagination']['PageNumber']);
        $req->setPagination($pagination);

        $res = $this->proxy->GetMemberMessages($req);
		$hasMoreItems = false;
        if ($this->testValid($res)) {
			$hasMoreItems = $res->getHasMoreItems();
			$memberMessages = $res->getMemberMessage();
			if (is_array($memberMessages)) {
				foreach ($memberMessages as &$memberMessage) {
					$question = $memberMessage->getQuestion();
					$messageID = $question->getMessageID();
					$duplicated = $bean->retrieve_by_string_fields(array('message_id'=>$messageID));

					$bean->xebayaccount_id = $account_id;

					$bean->name = $question->getSubject();
					$bean->description = $question->getBody();

					$bean->message_id = $messageID;
					$bean->message_type = $question->getMessageType();
					$bean->question_type = $question->getQuestionType();
					// $bean->recipient_id = $question->getRecipientID();
					$bean->sender_email = $question->getSenderEmail();
					$bean->sender_id = $question->getSenderID();

					$bean->creation_date = $memberMessage->getCreationDate();
					$bean->message_status = $memberMessage->getMessageStatus();

					$responses = $memberMessage->getResponse();
					$bean->responses = $this->getResponsesXml($responses);

					$item = $memberMessage->getItem();
					$bean->item_id = $item->getItemID();
					$bean->currency_id = $item->getSellingStatus()->getCurrentPrice()->getTypeAttribute('currencyID');
					$bean->price = $item->getSellingStatus()->getCurrentPrice()->getTypeValue();
					$bean->endtime = $item->getListingDetails()->getEndTime();
					$bean->view_item_url = $item->getListingDetails()->getViewItemURL();
					$bean->title = $item->getTitle();

					if ($bean->message_status == 'Answered') {
						$bean->replied = true;
						$bean->read_status = true;
					}

					if (empty($duplicated)) {
						if ($bean->message_status != 'Answered') {
							$bean->replied = false;
							$bean->read_status = false;
						}
						$bean->flagged = false;
						$bean->date_sent = '';
						$bean->id = create_guid();
						$bean->new_with_id = true;
					}
					$bean->save();
				}
			}

            return (true);
        } else {
            $this->dumpObject($res);
            return (false);
        }
	}
}

?>
