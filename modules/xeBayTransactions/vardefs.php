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

$dictionary['xeBayTransaction'] = array(
	'table'=>'xebaytransactions',
	'audited'=>true,
	'duplicate_merge'=>true,
	'fields'=>array (
		'order_id'=>
		array(
			'name'=>'order_id',
			'vname'=>'LBL_ORDER_ID',
			'type' => 'id',
		),
		'combine_order_id'=>
		array(
			'name'=>'combine_order_id',
			'vname'=>'LBL_COMBINE_ORDER_ID',
			'type' => 'id',
		),
		'actual_handling_cost_currency_id' => array(
			'name' => 'actual_handling_cost_currency_id',
			'vname' => 'LBL_ACTUAL_HANDLING_COST_CURRENCY_ID',
			'type' => 'varchar',
			'len' => '3',
		),
		'actual_handling_cost_value' => array(
			'name' => 'actual_handling_cost_value',
			'vname' => 'LBL_ACTUAL_HANDLING_COST_VALUE',
			'type' => 'double',
		),
		'actual_shipping_cost_currency_id' => array(
			'name' => 'actual_shipping_cost_currency_id',
			'vname' => 'LBL_ACTUAL_SHIPPING_COST_CURRENCY_ID',
			'type' => 'varchar',
			'len' => '3',
		),
		'actual_shipping_cost_value' => array(
			'name' => 'actual_shipping_cost_value',
			'vname' => 'LBL_ACTUAL_SHIPPING_COST_VALUE',
			'type' => 'double',
		),
		'create_time'=>
		array(
			'name'=>'create_time',
	    	'vname'=> 'LBL_CREATE_TIME',
	    	'type'=>'name',
			'dbType' => 'datetime',
		),
		'item_item_id' => array(
			'name' => 'item_item_id',
			'vname' => 'LBL_ITEM_ID',
			'type' => 'varchar',
			'len' => '20',
		),
		'item_site' => array(
			'name' => 'item_site',
			'vname' => 'LBL_ITEM_SITE',
			'type' => 'varchar',
			'len' => '20',
		),
		'item_sku' => array(
			'name' => 'item_sku',
			'vname' => 'LBL_ITEM_SKU',
			'type' => 'varchar',
			'len' => '50',
		),
		'orderline_item_id' => array(
			'name' => 'orderline_item_id',
			'vname' => 'LBL_ORDERLINE_ITEM_ID',
			'type' => 'varchar',
			'len' => '50',
		),
		'quantity_purchased' => array(
			'name' => 'quantity_purchased',
			'vname' => 'LBL_QUANTITY_PURCHASED',
			'type' => 'int',
		),
		'transaction_id' => array(
			'name' => 'transaction_id',
			'vname' => 'LBL_TRANSACTION_ID',
			'type' => 'varchar',
			'len' => '19',
		),
		'shipping_details_selling_manager_sales_record_number' => array(
			'name' => 'shipping_details_selling_manager_sales_record_number',
			'vname' => 'LBL_SHIPPING_DETAILS_SELLING_MANAGER_SALES_RECORD_NUMBER',
			'type' => 'int',
		),
		'transaction_price_currency_id' => array(
			'name' => 'transaction_price_currency_id',
			'vname' => 'LBL_TRANSACTION_PRICE_CURRENCY_ID',
			'type' => 'varchar',
			'len' => '3',
		),
		'transaction_price_value' => array(
			'name' => 'transaction_price_value',
			'vname' => 'TRANSACTION_PRICE_VALUE',
			'type' => 'double',
		),
		'variation_sku' => array(
			'name' => 'variation_sku',
			'vname' => 'LBL_VARIATION_SKU',
			'type' => 'varchar',
			'len' => '50',
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

VardefManager::createVardef('xeBayTransactions','xeBayTransaction', array('basic','assignable'));
