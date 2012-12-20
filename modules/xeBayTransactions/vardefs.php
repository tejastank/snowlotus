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
		'name' => array(
			'name' => 'name',
			'vname' => 'LBL_NAME',
			'type' => 'varchar',
			'len' => '80',
			'importable' => 'required',
            'required' => true
		),
		'item_view_item_url' => array(
			'name' => 'item_view_item_url',
			'vname' => 'LBL_ITEM_VIEW_ITEM_URL',
			'type' => 'url',
			'len' => '255',
		),
		'item_sku' => array(
			'name'=>'item_sku',
			'vname'=>'LBL_ITEM_SKU',
			'type'=>'id',
		),
		'inventory_name' => array(
			'name'=> 'inventory_name',
			'rname' => 'name',
			'vname'=>'LBL_RELATED_TO',
			'id_name'=>'item_sku',
			'type'=>'relate',
			'link'=>'inventory_link',
			'source'=>'non-db',
			'dbType' => 'varchar',
			'table' => 'xinventories',
			'module' => 'xInventories',
		),
		'inventory_link'=>
		array(
			'name' => 'inventory_link',
			'type' => 'link',
			'relationship' => 'xinventory_transaction',
			'vname' => 'LBL_RELATED_TO',
			'source'=>'non-db',
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
		'sales_record_number' => array(
			'name' => 'sales_record_number',
			'vname' => 'LBL_SALES_RECORD_NUMBER',
			'type' => 'int',
			'comment' => 'shipping details selling manager sales record number',
		),
		'price_currency_id' => array(
			'name' => 'price_currency_id',
			'vname' => 'LBL_PRICE_CURRENCY_ID',
			'type' => 'varchar',
			'len' => '3',
		),
		'price_value' => array(
			'name' => 'price_value',
			'vname' => 'LBL_PRICE_VALUE',
			'type' => 'double',
		),
	),
	'relationships'=>array (
		'xinventory_transaction' => array(
			'lhs_module'=> 'xInventories', 'lhs_table'=> 'xinventories', 'lhs_key' => 'id',
			'rhs_module' => 'xeBayTransactions', 'rhs_table'=> 'xebaytransactions', 'rhs_key' => 'item_sku',
			'relationship_type'=>'one-to-many'),
	),
	'optimistic_locking'=>true,
	'unified_search'=>true,
);

if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}

VardefManager::createVardef('xeBayTransactions','xeBayTransaction', array('basic','assignable'));
