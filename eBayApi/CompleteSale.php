<?php
/**
 * sources
 */
require_once 'eBayApiEnvironment.php';
require_once 'CompleteSaleRequestType.php';
require_once 'FeedbackInfoType.php';

/**
 * sample_GetOrders
 * 
 * Sample call for GetOrders
 * 
 * @package ebatns
 * @subpackage samples_trading
 * @author johann 
 * @copyright Copyright (c) 2008
 * @version $Id: sample_GetOrders.php,v 1.107 2012-09-10 11:01:21 michaelcoslar Exp $
 * @access public
 */
class CompleteSale extends eBayApiEnvironment
{

   /**
     * sample_CompleteSale::dispatchCall()
     * 
     * Dispatch the call
     *
     * @param array $params array of parameters for the eBay API call
     * 
     * @return boolean success
     */
	public function dispatchCall ($params)
    {
        $req = new CompleteSaleRequestType();
        $req->setItemID($params['ItemID']);
        $req->setTransactionID($params['TransactionID']);
		
        $res = $this->proxy->CompleteSale($req);
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

	public function endOfSale($params)
	{
        $req = new CompleteSaleRequestType();

		// Good buyer, prompt payment, valued customer, highly recommended.
		// Thank you for an easy, pleasant transaction. Excellent buyer. A++++++.
		// Quick response and fast payment. Perfect! THANKS!!
		// Hope to deal with you again. Thank you.
		$feedback = new FeedbackInfoType();
		$feedback->setCommentText("Quick response and fast payment. Perfect! THANKS!!");
		$feedback->setCommentType("Positive");
		$feedback->setTargetUser($params['TargetUser']);
		// $req->setFeedbackInfo($feedback);

        $req->setOrderID($params['OrderID']);
        $req->setItemID($params['ItemID']);
        $req->setTransactionID($params['TransactionID']);
        $req->setShipped(true);
	    $req->setPaid(true);

        $res = $this->proxy->CompleteSale($req);
        if ($this->testValid($res))
        {
            return (true);
        }
        else 
        {
            $this->dumpObject($res);
            return (false);
        }
	}
}

?>
