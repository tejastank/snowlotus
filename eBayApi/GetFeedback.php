<?php
/**
 * sources
 */
require_once 'eBayTradingApi.php';
require_once 'GetFeedbackRequestType.php';

/**
 * sample_GetSellerList
 * 
 * Sample call for GetSellerList
 * 
 * @package ebatns
 * @subpackage samples_trading
 * @author johann 
 * @copyright Copyright (c) 2008
 * @version $Id: sample_GetSellerList.php,v 1.107 2012-09-10 11:01:21 michaelcoslar Exp $
 * @access public
 */
class GetFeedback extends eBayTradingApi
{

   /**
     * sample_GetSellerList::dispatchCall()
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
    	
        $req = new GetFeedbackRequestType();
		//$req->setDetailLevel('ReturnAll');
		
		$pageNumber = 1;
		$pagination = new PaginationType();
		$pagination->setEntriesPerPage(20);
		$pagination->setPageNumber($pageNumber);
		$req->setPagination($pagination);
		$outputSelector = array(
			'HasMoreItems',
			'ItemArray.Item.ApplicationData',
			// 'ItemArray.Item.BuyItNowPrice',
			// 'ItemArray.Item.Currency',
			'ItemArray.Item.HitCount', /* may be not set */
			'ItemArray.Item.ItemID',
			'ItemArray.Item.ListingDetails.ConvertedStartPrice',
			'ItemArray.Item.ListingDetails.EndTime',
			'ItemArray.Item.ListingDetails.ViewItemURL',
			'ItemArray.Item.ListingDetails.ListingType',
			'ItemArray.Item.PictureDetails.PictureURL',
			'ItemArray.Item.Quantity',
			'ItemArray.Item.SellingStatus.BidCount',
			'ItemArray.Item.SKU', /* may be not set */
			'ItemArray.Item.Title',
			'ItemArray.Item.Variations',
			'ItemsPerPage',
			'PageNumber',
			'ReturnedItemCountActual',
		);
		
        $res = $this->proxy->GetFeedback($req);
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
	
	public function retrieveFeedback($params)
	{
		$this->session->setRequestToken($params['AuthToken']);
	
		$result = true;
	
		$req = new GetFeedbackRequestType();
		$req->setDetailLevel('ReturnAll');
	
		$pagination = new PaginationType();
		$pagination->setEntriesPerPage(200);
		$pageNumber = 1;
	
		$hasMoreItems = false;
		do {
			$pagination->setPageNumber($pageNumber++);
			$req->setPagination($pagination);
			$res = $this->proxy->GetFeedback($req);
			if ($this->testValid($res)) {
				$entriesPerPage = $res->getEntriesPerPage();
				$hasMoreItems = ($entriesPerPage == 200);
				$feedbackDetailArray = $res->getFeedbackDetailArray();
				if (empty($feedbackDetailArray)) {
					$result = false;
					break;
				}
				foreach ($feedbackDetailArray as &$feedback) {
					$commentTime = $feedback->getCommentTime();
					$orderLineItemID = $feedback->getOrderLineItemID();
					
					if ((strtotime($GLOBALS['timedate']->nowDb()) - strtotime($commentTime)) > 3600 * 24 * 30) {
						return true;
					}

					$bean = BeanFactory::getBean('xeBayTransactions');
					if ($bean->retrieve_by_string_fields(array('orderline_item_id'=>$orderLineItemID)) !== NULL) {
						$xebayorder_id = $bean->xebayorder_id;
						$bean = BeanFactory::getBean('xeBayOrders');
						$bean->feedback_received_update($xebayorder_id);
					}
				}
			} else {
				$this->dumpObject($res);
				$result = false;
				break;
			}
		} while ($hasMoreItems);
	
		return $result;
	}
	
	public function dumpUserFeedback($params)
	{
		$this->session->setRequestToken($params['AuthToken']);
	
		$result = true;
	
		$req = new GetFeedbackRequestType();
		$req->setUserID($params['UserID']);
		// $req->setDetailLevel('ReturnAll');
	
		$pagination = new PaginationType();
		$pagination->setEntriesPerPage(25);
		$pageNumber = 1;
	
		$pagination->setPageNumber($pageNumber++);
		$req->setPagination($pagination);
		$res = $this->proxy->GetFeedback($req);
		if ($this->testValid($res)) {
			$this->dumpObject($res);
			$result = true;
		} else {
			$this->dumpObject($res);
			$result = false;
		}
	
		return $result;
	}
}

?>
