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
	var $checked_out;
	var $redeliver_count;
    var $shipping_service;

	var $xebayaccount_id;
	var $xebayaccount_name;
	var $xebayaccount_link;

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

	var $xebaytransactions;

	protected static $complete_sale = null;
	protected static $ebay_accounts = null;

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

    function save($check_notify = FALSE)
    {
        $isUpdate = true;
        if(empty($this->id))
        {
            $isUpdate = false;
        }

		if ( $this->new_with_id == true )
		{
			$isUpdate = false;
		}
        if ($isUpdate || (($isUpdate == false) && empty($this->country_name))) {
		    $nationality = require_once('modules/xeBayOrders/nationality.php');
            $country_name = $nationality[$this->country];
            if (!empty($country_name))
                $this->country_name = $country_name['en'];
        }
		parent::save($check_notify);
    }

	function mark_deleted($id)
	{
		global $current_user;
		$date_modified = $GLOBALS['timedate']->nowDb();
		if(isset($_SESSION['show_deleted'])) {
			$this->mark_undeleted($id);
		} else {
            if ( isset($this->field_defs['modified_user_id']) ) {
                if (!empty($current_user)) {
                    $this->modified_user_id = $current_user->id;
                } else {
                    $this->modified_user_id = 1;
                }
                $query = "UPDATE $this->table_name set handled_status='deleted' , date_modified = '$date_modified', modified_user_id = '$this->modified_user_id' where id='$id'";
            } else {
                $query = "UPDATE $this->table_name set handled_status='deleted' , date_modified = '$date_modified' where id='$id'";
            }
            $this->db->query($query, true,"Error marking record deleted: ");
        }
	}

    function mark_undeleted($id)
	{
		$date_modified = $GLOBALS['timedate']->nowDb();
		$query = "UPDATE $this->table_name set handled_status='unhandled' , date_modified = '$date_modified' where id='$id'";
		$this->db->query($query, true,"Error marking record undeleted: ");
	}

	function mark_merged($id)
	{
		$date_modified = $GLOBALS['timedate']->nowDb();
		$query = "UPDATE $this->table_name set description='merged' , date_modified = '$date_modified' where id='$id'";
		$this->db->query($query, true,"Error marking record merged: ");
	}

	function print_status_update($id, $status)
	{
		global $current_user;
		$date_modified = $GLOBALS['timedate']->nowDb();
        if ( isset($this->field_defs['modified_user_id']) ) {
            if (!empty($current_user)) {
                $this->modified_user_id = $current_user->id;
            } else {
                $this->modified_user_id = 1;
            }
            $query = "UPDATE $this->table_name set print_status='{$status}' , date_modified = '$date_modified', modified_user_id = '$this->modified_user_id' where id='$id'";
        } else {
            $query = "UPDATE $this->table_name set print_status='{$status}' , date_modified = '$date_modified' where id='$id'";
        }
        $this->db->query($query, true,"Error marking record deleted: ");
	}

	function checked_out_update($id, $status)
	{
		global $current_user;
		$date_modified = $GLOBALS['timedate']->nowDb();
        if ( isset($this->field_defs['modified_user_id']) ) {
            if (!empty($current_user)) {
                $this->modified_user_id = $current_user->id;
            } else {
                $this->modified_user_id = 1;
            }
            $query = "UPDATE $this->table_name set checked_out='{$status}' , date_modified = '$date_modified', modified_user_id = '$this->modified_user_id' where id='$id'";
        } else {
            $query = "UPDATE $this->table_name set checked_out='{$status}' , date_modified = '$date_modified' where id='$id'";
        }
        $this->db->query($query, true,"Error marking record checked_out: ");
	}

	function handled_status_update($id, $status)
	{
		global $current_user;
		$date_modified = $GLOBALS['timedate']->nowDb();
        if ( isset($this->field_defs['modified_user_id']) ) {
            if (!empty($current_user)) {
                $this->modified_user_id = $current_user->id;
            } else {
                $this->modified_user_id = 1;
            }
            $query = "UPDATE $this->table_name set handled_status='{$status}' , date_modified = '$date_modified', modified_user_id = '$this->modified_user_id' where id='$id'";
        } else {
            $query = "UPDATE $this->table_name set handled_status='{$status}' , date_modified = '$date_modified' where id='$id'";
        }
        $this->db->query($query, true,"Error marking record deleted: ");
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
		$subpanel_definitions->layout_defs['subpanel_setup']['xebaytransactions']['subpanel_name'] = "ForOrderSimple";
		$thisPanel=$subpanel_definitions->load_subpanel("xebaytransactions");
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

	function automerge($ids = array(), $printed_order_included)
	{
		if (!is_array($ids))
			return $ids;

		$inventoryBean = BeanFactory::getBean('xInventories');
		$ebayOrderBean = BeanFactory::getBean('xeBayOrders');

		$address_ids = array();
		$orders = array();
		if (empty($ids)) {
			$where = "handled_status='unhandled'";
			if (empty($printed_order_included))
				$where .= " AND print_status<>'1'";
			$resp = $ebayOrderBean->get_list("", $where, 0, -99, -99, 0, false, array('id', 'address_id', 'address_owner'));
			foreach ($resp['list'] as &$order) {
				$address_ids[] = $order->address_id;
			}
			$orders = &$resp['list'];
		} else {
			$index = 0;
			$count = count($ids);
			while ($count > 0) {
				if ($count > 10)
					$number = 10;
				else 
					$number = $count;
				$count -= $number;
				$where = '';
				while ($number--) {
					if (!empty($where))
						$where .= ' OR ';
					$where .= "id='{$ids[$index++]}'";
				}
				$resp = $ebayOrderBean->get_list("", $where, 0, -99, -99, 0, false, array('id', 'address_id', 'address_owner'));
				foreach ($resp['list'] as &$order) {
					$address_ids[] = $order->address_id;
				}
				$orders = array_merge($orders, $resp['list']);
			}
		}

		$merged_ids = array();
		$ids = array();
		foreach ($orders as $order_key => &$order) {
			$address_id = $order->address_id;
			if (in_array($address_id, $merged_ids)) {
				continue;
			}
			$ids[] = $order->id;

			foreach ($address_ids as $transaction_key => &$value) {
				if (empty($address_id) || empty($value) || ($order_key == $transaction_key))
					continue;

				if ($address_id == $value) {
					unset($address_ids[$key]);
					$merged_ids[] = $value;
					$order_matched = $resp['list'][$transaction_key];
					$order_matched->load_relationship('xebaytransactions');
					$transactions = $order_matched->xebaytransactions->getBeans();
					foreach ($transactions as &$transaction) {
						$transaction->xebayorder_id = $order->id;
						$transaction->save();
					}
					$order_matched->mark_merged($orders[$transaction_key]->id);
					$order_matched->mark_deleted($orders[$transaction_key]->id);
				}
			}

		}

		return $ids;
	}

	function get_valid_ids($printed_order_included)
	{
		$ids = array();

		$query = "SELECT id, name FROM $this->table_name WHERE deleted=0 ";
		$query .= "AND handled_status='unhandled' ";
		if (empty($printed_order_included))
			$query .= " AND print_status<>'1' ";

		$result = $this->db->query($query, false);
		$GLOBALS['log']->debug("get valid printable ids: result is ".var_export($result, true));

		while (($row = $this->db->fetchByAssoc($result)) != null) {
			$ids[] = $row['id'];
		}

		return $ids;
	}

    function get_valid_orders($ids, $stockout_check, $automerge, $printed_order_included)
    {
		$bean = BeanFactory::getBean('xeBayOrders');
        $orders = array();

		if ($automerge) {
			$ids = $this->automerge($ids, $printed_order_included);
		} else {
			if (empty($ids)) {
				$ids = $this->get_valid_ids($printed_order_included);
			}
		}

		if (empty($ids)) {
			echo "<b>Not found any qualified orders</b>";
			sugar_cleanup(true);
		}

		set_time_limit(60 * 5);

		$nationality = require_once('modules/xeBayOrders/nationality.php');

		$count = 1;

		foreach ($ids as &$id) {
    	    $bean->retrieve($id);
			if (empty($printed_order_included)) {
				if (!empty($bean->print_status))
					continue;
			}
			$bean->load_relationship('xebaytransactions');
			$transactions = $bean->xebaytransactions->getBeans();
			if (empty($transactions))
				continue;

			if (($bean->checked_out != true) && !empty($stockout_check)) {
				$skip = false;
				foreach ($transactions as &$transaction) {
					if ($transaction->stockout_status()) {
						$bean->handled_status_update($bean->id, 'suspended');
						$skip = true;;
					}
					
				}
				if ($skip)
					continue;
			}

			if ($bean->checked_out != true) {
				// update checked out status, avoid duplicate sale record
				$bean->checked_out_update($bean->id, true);
			}
			if ($bean->print_status != true)
				$bean->print_status_update($bean->id, true);

			$weight = 0.0;
            $quantity = 0;
			$order_details = array();
			foreach ($transactions as &$transaction) {
				if ($bean->checked_out != true) {
					// new sale record
					$transaction->new_sale_record();
				}

                $declaration_name = empty($transaction->customs_declaration) ? $transaction->name : $transaction->customs_declaration;
				$weight += $transaction->weight * $transaction->quantity_purchased;
                $quantity += $transaction->quantity_purchased;
				$inventory_name = empty($transaction->xinventory_name) ? $transaction->name : $transaction->xinventory_name;

                $order_details[] = array(
                    'declaration_name' => $declaration_name,
                    'inventory_name' => $inventory_name,
                    'location' => $transaction->goods_allocation,
                    'quantity' => $transaction->quantity_purchased,
					'weight' => $transaction->weight,
                	'currency' => $transaction->price_currency_id,
                	'value' => $transaction->price_value,
                );
			}

            $total_weight = $weight;

            $orders[] = array(
                'buyer_user_id' => $bean->buyer_user_id,
                'sales_record_number' => $bean->sales_record_number,
                'name' => $bean->name,
                'street1' => $bean->street1,
                'street2' => $bean->street2,
                'city' => $bean->city_name,
                'state' => $bean->state_or_province,
                'postal_code' => $bean->postal_code,
                'country' => $bean->country,
                'country_name' => $bean->country_name,
                'country_name_cn' => $nationality[$bean->country]['cn'],
                'phone' => $bean->phone,
                'subtotal_currency' => $bean->subtotal_currency_id,
                'subtotal_value' => $bean->subtotal_value,
                'total_currency' => $bean->total_currency_id,
                'total_value' => $bean->total_value,
                'weight' => $weight,
                'total_weight' => $total_weight,
                'quantity' => $quantity,
                'shipping_service' => $bean->shipping_service,
                'order_details' => $order_details,
            );
		}

        return $orders;
    }

	function print_orders($ids, $stockout_check = true, $automerge = true, $printed_order_included = true)
	{
		$bean = BeanFactory::getBean('xeBayOrders');

		if ($automerge) {
			$ids = $this->automerge($ids, $printed_order_included);
		} else {
			if (empty($ids)) {
				$ids = $this->get_valid_ids($printed_order_included);
			}
		}

		if (empty($ids)) {
			echo "<b>Not found any qualified orders</b>";
			sugar_cleanup(true);
		}

		set_time_limit(60 * 5);

		$nationality = require_once('modules/xeBayOrders/nationality.php');
		$ss = new Sugar_Smarty();
        $ss->left_delimiter = '{{';
        $ss->right_delimiter = '}}';

		$count = 1;

		$ss->assign("MOD", $GLOBALS['mod_strings']);
		$ss->assign("INSTRUCTION", "<h1>Print orders</h1>");
		$orders = "";
		foreach ($ids as &$id) {
    	    $bean->retrieve($id);
			if (empty($printed_order_included)) {
				if (!empty($bean->print_status))
					continue;
			}
			$bean->load_relationship('xebaytransactions');
			$transactions = $bean->xebaytransactions->getBeans();
			if (empty($transactions))
				continue;

			if (($bean->checked_out != true) && !empty($stockout_check)) {
				$skip = false;
				foreach ($transactions as &$transaction) {
					if ($transaction->stockout_status()) {
						$bean->handled_status_update($bean->id, 'suspended');
						$skip = true;;
					}
					
				}
				if ($skip)
					continue;
			}

			if ($bean->checked_out != true) {
				// update checked out status, avoid duplicate sale record
				$bean->checked_out_update($bean->id, true);
			}
			if ($bean->print_status != true)
				$bean->print_status_update($bean->id, true);

			$customs_declaration = "";
			$transaction_count = 0;
			$total_weight = 0.0;
			$order_blank = "";
			foreach ($transactions as &$transaction) {
				if ($transaction_count++ < 4) {
                    $declaration_name = empty($transaction->customs_declaration) ? $transaction->name : $transaction->customs_declaration;
					$customs_declaration .= $declaration_name . "&nbsp;x" . $transaction->quantity_purchased . "<br/>";
				}
				if ($bean->checked_out != true) {
					// new sale record
					$transaction->new_sale_record();
				}
				$total_weight += $transaction->weight * $transaction->quantity_purchased;
				$ss->assign("NO", $transaction_count);
				$ss->assign("INVENTORY_NAME", $transaction->xinventory_name);
				$ss->assign("QUANTITY", $transaction->quantity_purchased);
				$ss->assign("GOODS_ALLOCATION", $transaction->goods_allocation);
				$order_blank .= $ss->fetch("modules/xeBayOrders/tpls/takesendlogistics-order-blank.html");
			}

        	$ss->assign("NAME", $bean->name);
			$ss->assign("STREET1", $bean->street1);
			$ss->assign("STREET2", $bean->street2);
			if (!empty($bean->city_name))
				$ss->assign("CITY_NAME", $bean->city_name . ',&nbsp;');
			else
				$ss->assign("CITY_NAME", '');
			if (!empty($bean->state_or_province))
				$ss->assign("STATE_OR_PROVINCE", $bean->state_or_province . ',&nbsp;');
			else
				$ss->assign("STATE_OR_PROVINCE", '');
			$ss->assign("POSTAL_CODE", $bean->postal_code);
        	$ss->assign("COUNTRY_NAME", $bean->country_name);
			if (!empty($nationality[$bean->country]['cn'])) {
				$country_zh_cn = $nationality[$bean->country]['cn'];
				$ss->assign("COUNTRY_ZH_CN", "&nbsp;($country_zh_cn)");
			} else {
				$ss->assign("COUNTRY_ZH_CN", '');
			}
			$ss->assign("PHONE", $bean->phone);

			$ss->assign("CONTENTS", $customs_declaration);
			$ss->assign("VALUE", $bean->subtotal_currency_id . "&nbsp" . $bean->subtotal_value);
			$ss->assign("TOTAL_VALUE", $bean->total_currency_id . "&nbsp" . $bean->total_value);
			$ss->assign("WEIGHT", $total_weight);
			$ss->assign("TOTAL_WEIGHT", $total_weight);
			$ss->assign("SALES_RECORD_NUMBER", $bean->sales_record_number);
			$ss->assign("ORDER_BLANK", $order_blank);

			if (($count++ % 4) == 0)
				$ss->assign("PAGE_BREAK", '<div style="clear:both;height:0.1cm;overflow:hidden;page-break-before:always;page-break-inside:avoid;font-size:0;"></div>');
			else
				$ss->assign("PAGE_BREAK", '');
  
			$orders .= $ss->fetch("modules/xeBayOrders/tpls/takesendlogistics-order.html");
		}
		$ss->assign("ORDERS", $orders);
		echo $ss->fetch("modules/xeBayOrders/tpls/takesendlogistics.html");

		sugar_cleanup(true);
	}

	function end_of_sale()
	{
        require_once('eBayApi/CompleteSale.php');
		if (empty($this->complete_sale))
			$this->complete_sale = new CompleteSale;

		if (empty($this->ebay_accounts)) {
			$ebayAccountBean = BeanFactory::getBean('xeBayAccounts');
			$this->ebay_accounts = $ebayAccountBean->get_accounts('All');
		}

		$this->load_relationship('xebaytransactions');
		$transactions = $this->xebaytransactions->getBeans();
		if (empty($transactions))
			return;

		$authToken = $this->ebay_accounts[$this->xebayaccount_id];
	
		foreach ($transactions as &$transaction) {
			if ($transaction->sales_record_number < 100)
				continue;
			$params['TargetUser'] = $this->buyer_user_id;
			// $params['OrderID'] = $this->order_id; 
    		$params['ItemID'] = $transaction->item_item_id;
    		$params['TransactionID'] = $transaction->transaction_id;
			$params['AuthToken'] = $authToken;
			$res = $this->complete_sale->endOfSale($params);
		}

		$this->handled_status_update($this->id, 'handled');
	}

	function end_of_sales($ids)
	{
		if (!is_array($ids))
			return;

		set_time_limit(60 * 10);

		$bean = BeanFactory::getBean('xeBayOrders');

		foreach ($ids as &$id) {
			if ($bean->retrieve($id) !== null) {
				$bean->end_of_sale();
			}
		}
	}

	function get_salutation()
	{
		return "Hi {$this->buyer_user_id},";
	}

	function get_template()
	{
		return "";
	}

	function get_signature()
	{
		return "Your sincerely.\n- {$this->xebayaccount_name}";
	}
}

function getHandledStatusDropDown()
{
    global $mod_strings;
    $list = array(
        'unhandled' => 'unhandled',
        'handled' => 'handled',
        'suspended' => 'suspended',
        'deleted' => 'deleted',
    );

    return $list;
}

function getShippingServiceDropDown()
{
    $list = array(
        'HKBAM' => '香港邮政平邮小包',
        'HKBRAM' => '香港邮政挂号小包',
        'SWBAM' => '瑞士邮政平邮小包',
        'SWBRAM' => '瑞士邮政挂号小包',
        'DEAM' => '德国邮政平邮小包',
        'DERAM' => '德国邮政挂号小包',
        'RM1' => '英国邮政平邮小包',
        'RM1R' => '英国邮政挂号小包',
        'CNAM' => '中国邮政平邮小包',
        'CNRAM' => '中国邮政挂号小包',
        'SGAM' => '新加坡邮政平邮小包(只限三态速递)',
        'SGRAM' => '新加坡邮政挂号小包',
        'WWAM' => '中国邮政外围平邮小包(只限三态速递)',
        'WWRAM' => '中国邮政外围挂号小包(只限三态速递)',
        'BPAM' => '比利时邮政平邮小包(只限三态速递)',
    );

    return $list;
}

function getPfcShippingService($express)
{
	static $pfc = array(
        'HKBAM' => '香港邮政小包挂号',
        'HKBRAM' => '香港邮政小包平邮',
        'SWBAM' => '瑞士邮政小包挂号',
        'SWBRAM' => '瑞士邮政小包平邮',
        'DEAM' => '德国邮政小包平邮',
        'DERAM' => '德国邮政小包挂号',
        'RM1' => '英国皇家邮政小包平邮',
        'RM1R' => '英国皇家邮政小包挂号',
        'CNAM' => '中国邮政小包挂号',
        'CNRAM' => '中国邮政小包 平邮',
        'SGAM' => '',
        'SGRAM' => '新加坡邮政小包挂号',
        'WWAM' => '',
        'WWRAM' => '',
        'BPAM' => '',
	);

	return $pfc[$express];
}

function getExpressCarrierDropDown()
{
    $list = array(
		'default' => 'Default',
		'_4px' => '递四方速递',
		'sfc' => '三态速递',
		'pfc' => '皇家物流',
    );

    return $list;
}

?>
