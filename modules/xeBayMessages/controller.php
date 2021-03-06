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

class xeBayMessagesController extends SugarController
{
    function action_test()
    {
		$_REQUEST['ebay_account_name'] = "testuser_xlongfeng";

		if (!empty($_REQUEST['ebay_account_name'])) {
			$name = $_REQUEST['ebay_account_name'];
			$bean = BeanFactory::getBean('xeBayAccounts');
			$accounts = $bean->get_accounts($name);
		}

		if (0) {
			require_once('eBayApi/GetMyMessages.php');
			$x = new GetMyMessages();
			$startTime = date("c", strtotime('now - 180 days'));
			$endTime = date("c", strtotime('now'));

			foreach ($accounts as $id => $authToken) {
				$x->retrieveMyMessages(array(
					// 'DetailLevel' => 'ReturnMessages',
					'DetailLevel' => 'ReturnHeaders',
					'AccountID' => $id,
					'AuthToken' => $authToken,
					'StartTime' => $startTime,
					'EndTime' => $endTime,
				));
			}
			exit;
		}

		if (1) {
			require_once('eBayApi/GetMemberMessages.php');
			$x = new GetMemberMessages();
			$startCreationTime = date("c", strtotime('now - 360 days'));
			$endCreationTime = date("c", strtotime('now - 1 days'));

			foreach ($accounts as $id => $authToken) {
				$x->retrieveMemberMessages(array(
					'AccountID' => $id,
					'AuthToken' => $authToken,
					'MailMessageType' => 'All',
					'StartCreationTime' => $startCreationTime,
					'EndCreationTime' => $endCreationTime,
					'pagination' => array(
						'EntriesPerPage' => '100',
						'PageNumber' => '1')
					)
				);
			}
			exit;
		}
    }
}
?>
