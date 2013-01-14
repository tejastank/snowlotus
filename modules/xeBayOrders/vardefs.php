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

$dictionary['xeBayOrder'] = array(
	'table'=>'xebayorders',
	'audited'=>true,
	'fields'=>array (
		'handled_status'=>
		array(
			'name'=>'handled_status',
	    	'vname'=> 'LBL_HANDLED_STATUS',
            'type'=>'enum',
            'function'=>'getHandledStatusDropDown',
	    	'len'=>32,
			'default'=>'unhandled',
			'comment' => 'values: unhandled, handled, suspended, deleted',
		),
		'print_status'=>
		array(
			'name'=>'print_status',
	    	'vname'=> 'LBL_PRINT_STATUS',
	    	'type'=>'bool',
			'default'=>false,
		),
		'checked_out'=>
		array(
			'name'=>'checked_out',
	    	'vname'=> 'LBL_CHECKED_OUT',
	    	'type'=>'bool',
			'default'=>false,
		),
		'redeliver_count'=>
		array(
			'name'=>'redeliver_count',
	    	'vname'=> 'LBL_REDELIVER_COUNT',
	    	'type'=>'int',
			'default'=>0,
		),
        'shipping_service'=>
        array(
            'name'=>'shipping_service',
            'vname'=>'LBL_SHIPPING_SERVICE',
            'type'=>'enum',
            'function'=>'getShippingServiceDropDown',
			'len'=>'32',
            'default'=>'HKBAM',
        ),
		'xebayaccount_id'=>
		array(
			'name'=>'xebayaccount_id',
			'vname'=>'LBL_EBAY_ACCOUNT_ID',
			'type' => 'id',
		),
		'xebayaccount_name'=>
		array(
			'name'=>'xebayaccount_name',
			'rname' => 'name',
			'vname'=>'LBL_EBAY_ACCOUNT',
			'id_name'=>'xebayaccount_id',
			'type'=>'relate',
			'link'=>'xebayaccount_link',
			'reportable'=>false,
			'source'=>'non-db',
			'dbType' => 'varchar',
			'table' => 'xebayaccounts',
			'module' => 'xeBayAccounts',
		),
		'xebayaccount_link'=>
		array(
			'name' => 'xebayaccount_link',
			'type' => 'link',
			'relationship' => 'xebayorders_xebayaccount',
			'vname' => 'LBL_EBAY_ACCOUNT',
			'source'=>'non-db',
		),
		'buyer_checkout_message'=>
		array(
			'name'=>'buyer_checkout_message',
			'vname'=>'LBL_BUYER_CHECKOUT_MESSAGE',
			'type'=>'text',
		),
		'order_id'=>
		array(
			'name'=>'order_id',
	    	'vname'=> 'LBL_ORDER_ID',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>64,
		),
		'checkout_status_last_modified_time'=>
		array(
			'name'=>'checkout_status_last_modified_time',
	    	'vname'=> 'LBL_CHECKOUT_STATUS_LAST_MODIFIED_TIME',
	    	'type'=>'datetime',
		),
		'order_status'=>
		array(
			'name'=>'order_status',
	    	'vname'=> 'LBL_ORDER_STATUS',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>16,
		),
		'buyer_user_id'=>
		array(
			'name'=>'buyer_user_id',
	    	'vname'=> 'LBL_BUYER_USER_ID',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>32,
		),
		'subtotal_currency_id' => array(
			'name' => 'subtotal_currency_id',
			'vname' => 'LBL_SUBTOTAL_CURRENCY_ID',
			'type' => 'varchar',
			'len' => '3',
		),
		'subtotal_value' => array(
			'name' => 'subtotal_value',
			'vname' => 'LBL_SUBTOTAL_VALUE',
			'type' => 'double',
		),
		'total_currency_id' => array(
			'name' => 'total_currency_id',
			'vname' => 'LBL_TOTAL_CURRENCY_ID',
			'type' => 'varchar',
			'len' => '3',
		),
		'total_value' => array(
			'name' => 'total_value',
			'vname' => 'LBL_TOTAL_VALUE',
			'type' => 'double',
		),
		'paid_time'=>
		array(
			'name'=>'paid_time',
	    	'vname'=> 'LBL_PAID_TIME',
	    	'type'=>'name',
			'dbType' => 'datetime',
		),
		'shipped_time'=>
		array(
			'name'=>'shipped_time',
	    	'vname'=> 'LBL_SHIPPED_TIME',
	    	'type'=>'name',
			'dbType' => 'datetime',
		),
		'sales_record_number' => array(
			'name' => 'sales_record_number',
			'vname' => 'LBL_SALES_RECORD_NUMBER',
			'type' => 'int',
			'default' => -1,
		),
		'eias_token'=>
		array(
			'name'=>'eias_token',
	    	'vname'=> 'LBL_EIAS_TOKEN',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>128,
		),
		'payment_hold_status'=>
		array(
			'name'=>'payment_hold_status',
	    	'vname'=> 'LBL_PAYMENT_HOLD_STATUS',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>24,
		),
		// ShippingAddress
		'name'=>
		array(
			'name'=>'name',
	    	'vname'=> 'LBL_NAME',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>128,
    		'audited'=>true,
		),
		'street1'=>
		array(
			'name'=>'street1',
	    	'vname'=> 'LBL_STREET1',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>256,
    		'audited'=>true,
		),
		'street2'=>
		array(
			'name'=>'street2',
	    	'vname'=> 'LBL_STREET2',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>256,
    		'audited'=>true,
		),
		'city_name'=>
		array(
			'name'=>'city_name',
	    	'vname'=> 'LBL_CITY_NAME',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>64,
    		'audited'=>true,
		),
		'state_or_province'=>
		array(
			'name'=>'state_or_province',
	    	'vname'=> 'LBL_STATE_OR_PROVINCE',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>64,
    		'audited'=>true,
		),
		'country'=>
		array(
			'name'=>'country',
	    	'vname'=> 'LBL_COUNTRY',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>12,
    		'audited'=>true,
		),
		'country_name'=>
		array(
			'name'=>'country_name',
	    	'vname'=> 'LBL_COUNTRY_NAME',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>64,
    		'audited'=>true,
		),
		'phone'=>
		array(
			'name'=>'phone',
	    	'vname'=> 'LBL_PHONE',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>64,
    		'audited'=>true,
		),
		'postal_code'=>
		array(
			'name'=>'postal_code',
	    	'vname'=> 'LBL_POSTAL_CODE',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>24,
    		'audited'=>true,
		),
		'address_id'=>
		array(
			'name'=>'address_id',
	    	'vname'=> 'LBL_ADDRESS_ID',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>16,
		),
		'address_owner'=>
		array(
			'name'=>'address_owner',
	    	'vname'=> 'LBL_ADDRESS_OWNER',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>12,
		),
		'external_address_id'=>
		array(
			'name'=>'external_address_id',
	    	'vname'=> 'LBL_EXTERNAL_ADDRESS_ID',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>16,
		),
		// TransactionArray
		'xebaytransactions'=>
		array(
			'name'=>'xebaytransactions',
			'vname'=>'LBL_TRANSACTIONS',
			'type'=>'link',
			'relationship' => 'xebaytransactions_xebayorder',
			'module'=>'xeBayTransactions',
			'bean_name'=>'xeBayTransaction',
			'source'=>'non-db',
		),
	),
	'indices' => array (
		array('name' =>'idx_ebayorder_id_handle_del', 'type' =>'index', 'fields'=>array('id', 'handled_status', 'deleted')),
	),
	'relationships'=>array (
		'xebayorders_xebayaccount' => array(
			'lhs_module'=> 'xeBayAccounts', 'lhs_table'=> 'xebayaccounts', 'lhs_key' => 'id',
			'rhs_module' => 'xeBayOrders', 'rhs_table'=> 'xebayorders', 'rhs_key' => 'xebayaccount_id',
			'relationship_type'=>'one-to-many'),
	),
	'optimistic_locking'=>true,
	'unified_search'=>true,
);

if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}

VardefManager::createVardef('xeBayOrders','xeBayOrder', array('basic','assignable'));

