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
	'duplicate_merge'=>true,
	'fields'=>array (
		'handled_status'=>
		array(
			'name'=>'handled_status',
	    	'vname'=> 'LBL_HANDLED_STATUS',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>16,
			'comment' => 'values: unhandled, handled, suspended',
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
		'create_time'=>
		array(
			'name'=>'create_time',
	    	'vname'=> 'LBL_CREATE_TIME',
	    	'type'=>'name',
			'dbType' => 'datetime',
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
		'ship_to_address_id'=>
		array(
			'name'=>'ship_to_address_id',
			'vname'=>'LBL_SHIP_TO_ADDRESS_ID',
			'type' => 'id',
		),
		'shipping_details_selling_manager_sales_record_number' => array(
			'name' => 'shipping_details_selling_manager_sales_record_number',
			'vname' => 'LBL_SHIPPING_DETAILS_SELLING_MANAGER_SALES_RECORD_NUMBER',
			'type' => 'int',
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
	),
	'relationships'=>array (
	),
	'optimistic_locking'=>true,
	'unified_search'=>true,
);

if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}

VardefManager::createVardef('xeBayOrders','xeBayOrder', array('basic','assignable'));

