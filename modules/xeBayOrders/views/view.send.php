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
require_once('eBayApi/AddMemberMessageAAQToPartner.php');

class xeBayOrdersViewSend extends SugarView {

	function xeBayOrdersViewSend()
    {
 		parent::SugarView();
	}
	
    function process()
    {
		$account = BeanFactory::getBean('xeBayAccounts', $this->bean->xebayaccount_id);
		$subject = $_REQUEST['subject'];
		$message = $_REQUEST['message'];
		$questionType = $_REQUEST['question_type'];
        $itemID = $_REQUEST['item_id'];

		if (empty($message) || empty($subject) || empty($itemID))
			header("Location: index.php?module=xeBayOrders&action=DetailView&record={$this->bean->id}");

        $x = new AddMemberMessageAAQToPartner();
        $res = $x->addMemberMessage(array(
            'AccountID' => $account->id,
            'AuthToken' => $account->ebay_auth_token,
            'ItemID' => $itemID,
            'Body' => $message,
            'QuestionType' => $questionType,
            'RecipientID' => $this->bean->buyer_user_id,
            'Subject' => $subject,
            )
        );

		if ($res == true)
			header("Location: index.php?module=xeBayOrders&action=DetailView&record={$this->bean->id}");

		parent::process();
	}
	
	function display()
	{
		// sugar_cleanup(true);
	}
}

?>
