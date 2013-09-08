<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

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

/*********************************************************************************

 * Description: Controller for the Import module
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 ********************************************************************************/

require_once("include/MVC/Controller/SugarController.php");

class xeBayUsersController extends SugarController
{
    function action_sync()
    {
		$id = $_REQUEST['xebayuser_id'];
		if (empty($id))
			return;

		$user = BeanFactory::getBean('xeBayUsers', $id);
		if (!empty($user)) {
			require_once('eBayApi/GetUser.php');
            require_once('eBayApi/GetSellerList.php');
			// require_once('eBayApi/GetUserProfile.php');

			$bean = BeanFactory::getBean('xeBayAccounts');
			$accounts = $bean->get_accounts('All');

			$x = new GetUser();
			// $x = new GetUserProfile();

			$res = $x->dispatchCall(array(
				'UserID' => $user->name,
				'AuthToken' => current($accounts),
			));

			if ($res !== false) {
				$user->feedbackscore = $res['FeedbackScore'];
				$user->registrationdate = $res['RegistrationDate'];
				// $user->selleritemsurl = $res[''];
				$user->sellerlevel = $res['FeedbackRatingStar'];
				// $user->storename = $res[''];
				$user->site = $res['Site'];
				$user->storeurl = $res['StoreURL'];
				$user->save();
			} else {
				sugar_cleanup(true);
			}

			if ($res !== false) {
				date_default_timezone_set("America/Los_Angeles");
				set_time_limit(60*30);
				
				$sellerList = new GetSellerList();
				$endTimeFrom = date("c", time());
				$endTimeTo = date("c", time() + 60 * 60 * 24 * 30);

				$res = $sellerList->retrieveSellerSurveyList(array(
					'UserID' => $user->name,
					'xeBayUserID' => $user->id,
					'EndTimeFrom' => $endTimeFrom,
					'EndTimeTo' => $endTimeTo,
					'AuthToken' => current($accounts),
				));

				if ($res === false) {
					sugar_cleanup(true);
				}
			}
		}

		$this->redirect_url = "index.php?module=xeBayUsers&action=DetailView&record={$user->id}";
    }
    
    function action_feedback()
    {
    	$id = $_REQUEST['xebayuser_id'];
    	if (empty($id))
    		return;
    
    	$user = BeanFactory::getBean('xeBayUsers', $id);
    	if (!empty($user)) {
    		require_once('eBayApi/GetFeedback.php');
    
    		$bean = BeanFactory::getBean('xeBayAccounts');
    		$accounts = $bean->get_accounts('All');
    		
    		$api = new GetFeedback();
    
    		$res = $api->dumpUserFeedback(array(
    				'UserID' => $user->name,
    				'AuthToken' => current($accounts),
    		));
    	}
    	sugar_cleanup(true);
    }
}
?>
