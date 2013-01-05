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


/**
 * xeBaySellerListsViewImport.php
 * 
 * This class overrides SugarView and provides an implementation for the ValidPortalUsername
 * method used for checking whether or not an existing portal user_name has already been assigned.
 * We take advantage of the MVC framework to provide this action which is invoked from
 * a javascript AJAX request.
 * 
 * @author xlongfeng
 * */
 
require_once('include/MVC/View/SugarView.php');

class xeBaySellerListsViewImport extends SugarView 
{
 	/**
     * @see SugarView::display()
     */
    public function display()
    {
		$ss = new Sugar_Smarty();
        $ss->assign("MOD", $GLOBALS['mod_strings']);
        $ss->assign("INSTRUCTION", "<h1>Retrieve seller list from ebay</h1>");

		$bean = BeanFactory::getBean('xeBayAccounts');
		$resp = $bean->get_list("", "ebay_auth_token<>''", 0, -1, -1, 0, false, array('name'));
		if ($resp['row_count'] > 0) {
			$ebay_account_options =  "<select name='ebay_account_name' id='ebay_account_name' title=''>";
			if ($resp['row_count'] > 1)
				$ebay_account_options .= "<option value='All'>All</option>";
			foreach($resp['list'] as &$account) {
				$name = $account->name;
				$ebay_account_options .= "<option value='$name'>$name</option>";
			}
			$ebay_account_options .=  "</select>";
        	$ss->assign("EBAY_ACCOUNT_OPTIONS", $ebay_account_options);
		}

      	$javascript = <<<EOQ
function ImportConfirm()
{
		return confirm("Do you want to retrieve seller list now ?");
}
EOQ;
      	$ss->assign("JAVASCRIPT", $javascript);
		echo $ss->fetch("modules/xeBaySellerLists/tpls/import.tpl");
 	}
}
