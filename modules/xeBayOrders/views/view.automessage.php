<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2012 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

require_once('include/MVC/View/SugarView.php');
require_once('eBayApi/GetFeedback.php');
require_once('eBayApi/AddMemberMessageAAQToPartner.php');

class xeBayOrdersViewAutomessage extends SugarView {
	
	var $accounts;
	
	var $lessThan7Days = array();
	var $lessThan15Days = array();
	var $lessThan25Days = array();
	var $lessThan30Days = array();

	function xeBayOrdersViewAutomessage()
    {
    	date_default_timezone_set("America/Los_Angeles");
		set_time_limit(60*30);
		
    	$bean = BeanFactory::getBean('xeBayAccounts');
		$this->accounts = $bean->get_accounts();
		
 		parent::SugarView();
	}
	
	function send_comfort_message($bean, $duration)
	{
		$bean->load_relationship('xebaytransactions');
		$transactions = $bean->xebaytransactions->getBeans();
		foreach ($transactions as &$transaction) {
			$buyer_user_id = $bean->buyer_user_id;
			$xebayaccount_id = $transaction->xebayaccount_id;
			$subject = $transaction->name;
			$message = "abc";
			$questionType = 'Shipping';
			$itemID = $transaction->item_item_id;
			$message = '';
			switch ($duration) {
			case '25th Day':
				$message = <<<EOF
Hi friend.
  Your item has been shipped on {$bean->shipped_time} by HongKong air mail, and it may take about 7~15 days to arrive,
  sometimes it may be delayed by unexpected reason like holiday, custom`s process, weather condition etc.
  It may be delayed up to 35 days to arrive. If you have any question, feel free to contact us asap.
EOF;
			case '15th Day':
				$message = <<<EOF
Hi friend.
  Your item has been shipped on {$bean->shipped_time} by HongKong air mail, and it may take about 7~15 days to arrive,
  sometimes it may be delayed by unexpected reason like holiday, custom`s process, weather condition etc.
  It may be delayed up to 35 days to arrive. If you have any question, feel free to contact us asap.
EOF;
				break;
			default:
				$message = <<<EOF
Hi friend.
  Your item has been shipped on {$bean->shipped_time} by HongKong air mail, and it may take about 7~15 days to arrive,
  sometimes it may be delayed by unexpected reason like holiday, custom`s process, weather condition etc.
  It may be delayed up to 35 days to arrive. If you have any question, feel free to contact us asap.
EOF;
				break;
			}
			echo "<pre>$message</pre>";
			$api = new AddMemberMessageAAQToPartner();
        	//$res = $api->addMemberMessage(array(
            	//'AccountID' => $xebayaccount_id,
            	//'AuthToken' => $this->accounts[$xebayaccount_id],
            	//'ItemID' => $itemID,
            	//'Body' => $message,
            	//'QuestionType' => $questionType,
            	//'RecipientID' => $buyer_user_id,
            	//'Subject' => $subject,
            //));
            //$bean->buyer_comfort_status_update($bean->id, $duration);
			break;
		}
	}

    function process()
    {
		$api = new GetFeedback();
    	foreach ($this->accounts as $id => $authToken) {
			$result = $api->retrieveFeedback(array(
				'AuthToken' => $authToken,
			));
		}

    	$bean = BeanFactory::getBean('xeBayOrders');
    	$shippedTime30Days = date('Y-m-d H:i:s', strtotime($GLOBALS['timedate']->nowDb() . ' -30 days'));
		$where = "handled_status='handled' AND shipped_time>'{$shippedTime30Days}' AND feedback_received='0'";
		$beans = $bean->get_full_list("", $where);
		if ($beans !== null) {
			foreach($beans as &$bean) {
				$shipped_time = strtotime($bean->shipped_time);
				$current_time = strtotime($GLOBALS['timedate']->nowDb());
				$diff_time = $current_time - $shipped_time;
				if ($diff_time > 25 * 3600 * 24) {
					if ($bean->buyer_comfort_status != '25th Day') {
						$this->send_comfort_message($bean, '25th Day');
						$this->lessThan30Days[] = $bean->sales_record_number;
					}
				} else if ($diff_time > 15 * 3600 * 24) {
					if ($bean->buyer_comfort_status != '15th Day') {
						$this->send_comfort_message($bean, '15th Day');
						$this->lessThan25Days[] = $bean->sales_record_number;
					}
				} else if ($diff_time > 7 * 3600 * 24) {
					if ($bean->buyer_comfort_status != '7th Day') {
						$this->send_comfort_message($bean, '7th Day');
						$this->lessThan15Days[] = $bean->sales_record_number;
					}
				} else {
					$this->lessThan7Days[] = $bean->sales_record_number;
				}
			}
		}

		parent::process();
	}
	
	function display()
	{
		echo "<br><h2>Shipped Time Less than 30 Days</h2>";
		echo "<ul>";
		foreach($this->lessThan30Days as $record) {
			echo "<li>{$record}<li/>";
		}
		echo "</ul>";
		
		echo "<br><h2>Shipped Time Less than 25 Days</h2>";
		echo "<ul>";
		foreach($this->lessThan25Days as $record) {
			echo "<li>{$record}<li/>";
		}
		echo "</ul>";
		
		echo "<br><h2>Shipped Time Less than 15 Days</h2>";
		echo "<ul>";
		foreach($this->lessThan15Days as $record) {
			echo "<li>{$record}<li/>";
		}
		echo "</ul>";
		
		echo "<br><h2>Shipped Time Less than 7 Days</h2>";
		echo "<ul>";
		foreach($this->lessThan7Days as $record) {
			echo "<li>{$record}<li/>";
		}
		echo "</ul>";
	}
}

?>
