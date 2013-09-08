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


require_once('include/MVC/View/views/view.detail.php');

class xeBayUsersViewDetail extends ViewDetail
{
	function xeBayUsersViewDetail()
	{
 		parent::ViewDetail();
 	}

 	/**
 	 * display
 	 * Override the display method to support customization for the buttons that display
 	 * a popup and allow you to copy the account's address into the selected contacts.
 	 * The custom_code_billing and custom_code_shipping Smarty variables are found in
 	 * include/SugarFields/Fields/Address/DetailView.tpl (default).  If it's a English U.S.
 	 * locale then it'll use file include/SugarFields/Fields/Address/en_us.DetailView.tpl.
 	 */
 	function display(){
		global $mod_strings;
				
		if(empty($this->bean->id)){
			global $app_strings;
			sugar_die($app_strings['ERROR_NO_RECORD']);
		}

      	$javascript = <<<EOQ
<script>
function  sync_sell_listings()
{
	if (confirm("Do you want to sync {$this->bean->name}'s listings now ?")) {
		window.location = "index.php?module=xeBayUsers&action=sync&xebayuser_id={$this->bean->id}&return_module=xeBayUsers&return_action=index";
	}
	return false;
}
function view_feedback_details()
{
	if (confirm("Do you want to view {$this->bean->name}'s feedback details now ?")) {
		window.location = "index.php?module=xeBayUsers&action=feedback&xebayuser_id={$this->bean->id}&return_module=xeBayUsers&return_action=index";
	}
	return false;
}
</script>
EOQ;
		echo $javascript;

        $sync = "<a href='index.php?module=xeBayUsers&action=sync&xebayuser_id={$id}&return_module=xeBayUsers&return_action=index' title='{$mod_strings['LBL_SYNC']}'>{$sync_icon}</a>";

		$this->dv->process();

		$sync_url = "<input title='{$mod_strings['LBL_SYNC']}' class='button' type='submit' name='button' value='{$mod_strings['LBL_SYNC']}' id='sync_url' onclick='return sync_sell_listings();'>";
		$sync_url .= "&nbsp;&nbsp;";
		$sync_url .= "<input title='{$mod_strings['LBL_FEEDBACK']}' class='button' type='submit' name='button' value='{$mod_strings['LBL_FEEDBACK']}' id='feedback_url' onclick='return view_feedback_details();'>";
		$this->ss->assign("SYNC_URL", $sync_url);

		$sale_status = $this->bean->get_sale_status();
		$this->ss->assign("MONTHLY_SALES", $sale_status['monthly_sales']);
		$this->ss->assign("MONTHLY_SALES_AMOUNT", $sale_status['monthly_sales_amount']);
		$this->ss->assign("NOT_SELLING_RATE", $sale_status['not_selling_rate']);

		echo $this->dv->display();
 	} 	
}

?>
