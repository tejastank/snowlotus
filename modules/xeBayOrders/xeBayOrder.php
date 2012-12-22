<?PHP
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

class xeBayOrder extends Basic {
	var $new_schema = true;
	var $module_dir = 'xeBayOrders';
	var $object_name = 'xeBayOrder';
	var $table_name = 'xebayorders';
	var $importable = true;
	var $disable_row_level_security = true ; // to ensure that modules created and deployed under CE will continue to function under team security if the instance is upgraded to PRO
	var $id;
	var $date_entered;
	var $date_modified;
	var $modified_user_id;
	var $modified_by_name;
	var $created_by;
	var $created_by_name;
	var $description;
	var $deleted;
	var $created_by_link;
	var $modified_user_link;
	var $assigned_user_id;
	var $assigned_user_name;
	var $assigned_user_link;

	var $handled_status;
	var $print_status;
	var $redeliver_count;
	var $buyer_checkout_message;
	var $order_id;
	var $checkout_status_last_modified_time;
	var $order_status;
	var $buyer_user_id;
	var $subtotal_currency_id;
	var $subtotal_value;
	var $total_currency_id;
	var $total_value;
	var $paid_time;
	var $shipped_time;
	var $sales_record_number;
	var $eias_token;
	var $payment_hold_status;

	var $name;
	var $street1;
	var $street2;
	var $city_name;
	var $state_or_province;
	var $country;
	var $country_name;
	var $phone;
	var $postal_code;
	var $address_id;
	var $address_owner;
	var $external_address_id;

	var $transactions = array();

	function xeBayOrder()
	{
		parent::Basic();
	}
	
	function bean_implements($interface)
	{
		switch ($interface) {
			case 'ACL': return true;
		}
		return false;
	}

	// function retrieve($id = -1, $encode=true, $deleted=true)
	// {
		// parent::retrieve($id, $encode, $deleted);
		// $orderTransaction = BeanFactory::getBean('xeBayTransactions');
		// $this->transactions = $orderTransaction->get_full_list("", "order_id='$this->id'");
	// }

    function save($check_notify = FALSE)
	{
		if (!empty($this->shipped_time))
			$this->local_order_status = 'Shipped';

		parent::save(check_notify);
	}

	function create_new_list_query($order_by, $where,$filter=array(),$params=array(), $show_deleted = 0,$join_type='', $return_array = false,$parentbean=null, $singleSelect = false, $ifListForExport = false)
	{
		if (!empty($_REQUEST['filter']) && $_REQUEST['filter'] == 'deleted')
			$show_deleted = 1;
		return parent::create_new_list_query($order_by, $where,$filter,$params, $show_deleted,$join_type, $return_array,$parentbean, $singleSelect, $ifListForExport);
	}

	function get_list_view_data()
	{
        global $app_strings;
        global $mod_strings;

		$field_list = $this->get_list_view_array();

		$bean = BeanFactory::getBean('xeBayOrders');
		$bean->retrieve($field_list['ID']);

		require_once('include/SubPanel/SubPanelDefinitions.php');
		$subpanel_definitions=new SubPanelDefinitions($bean);
		$subpanel_definitions->layout_defs['subpanel_setup']['transactions']['subpanel_name'] = "ForOrderSimple";
		$thisPanel=$subpanel_definitions->load_subpanel("transactions");
        ob_start();
        include_once('include/SubPanel/SubPanel.php');
        $subpanel_object = new SubPanel('xeBayOrders', $field_list['ID'], 'all', $thisPanel);
        $subpanel_object->setTemplateFile('modules/xeBayTransactions/SubPanelDynamic.html');
		$subpanel_object->display();
        $subpanel_data = ob_get_contents();
        @ob_end_clean();

		$order_details .= '<p style="margin: 8px 0px 8px 0px;">';
		$order_details .= $field_list['BUYER_USER_ID'];
		$order_details .= '</p>';
		$order_details .= $subpanel_data;
		$field_list['ORDER_DETAILS'] = $order_details;

		if (!empty($field_list['BUYER_CHECKOUT_MESSAGE'])) {
        	$message = "<img alt='{$mod_strings['LBL_MESSAGE']}' style='padding: 0px 5px 0px 2px' border='0' onclick=\"SUGAR.util.getStaticAdditionalDetails(this,'";
			$message .= str_replace(array("&#039;"), array("\'"), $field_list['BUYER_CHECKOUT_MESSAGE']);
			// $message .= $field_list['BUYER_CHECKOUT_MESSAGE'];
        	$message .= "','<div style=\'float:left\'>{$mod_strings['LBL_MESSAGE']}</div><div style=\'float: right\'>";
        	$closeVal = "false";
        	$message .= "',".$closeVal.")\" src='".SugarThemeRegistry::current()->getImageURL('AlertEmailTemplates.gif')."' class='info'>";

			$field_list['BUYER_CHECKOUT_MESSAGE'] = $message;
		}

		if ($field_list['PRINT_STATUS']) {
			$field_list['PRINT_STATUS_ICON'] = "<img alt='Print status' border='0' src='" . SugarThemeRegistry::current()->getImageURL('Print_Email.gif')."'>";
		}

		return $field_list;
	}

	function print_orders($ids)
	{
		$ss = new Sugar_Smarty();
        $ss->left_delimiter = '{{';
        $ss->right_delimiter = '}}';

		$bean = BeanFactory::getBean('xeBayOrders');
		$count = 1;
		$ids[1] = $ids[0];
		// $ids[2] = $ids[0];
		// $ids[3] = $ids[0];
		// $ids[4] = $ids[0];
		// $ids[5] = $ids[0];
		// $ids[6] = $ids[0];
		// $ids[7] = $ids[0];
		// $ids[8] = $ids[0];
		// $ids[9] = $ids[0];
		// $ids[10] = $ids[0];
		// $ids[11] = $ids[0];

		$ss->assign("MOD", $GLOBALS['mod_strings']);
		$ss->assign("INSTRUCTION", "<h1>Print orders</h1>");
		$orders = "";
		foreach ($ids as &$id) {
    	    $bean->retrieve($id);
			$bean->print_status = true;
			$bean->save();

			$bean->load_relationship('transactions');
			$transactions = $bean->transactions->getBeans();

        	$ss->assign("NAME", $bean->name);
			$ss->assign("STREET1", $bean->street1);
			$ss->assign("STREET2", $bean->street2);
			$ss->assign("CITY_NAME", $bean->city_name);
			$ss->assign("STATE_OR_PROVINCE", $bean->state_or_province);
			$ss->assign("POSTAL_CODE", $bean->postal_code);
        	$ss->assign("COUNTRY_NAME", $bean->country_name);
			$ss->assign("PHONE", $bean->phone);
			if (($count++ % 4) == 0)
				$ss->assign("PAGE_BREAK", "page-break-before:always;page-break-inside:avoid;font-size:0;");
			$orders .= $ss->fetch("modules/xeBayOrders/tpls/takesendlogistics-order.html");
		}
		$ss->assign("ORDERS", $orders);
		echo $ss->fetch("modules/xeBayOrders/tpls/takesendlogistics.html");

		sugar_cleanup(true);
	}
}
?>
