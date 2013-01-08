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
			'relationship' => 'xebaytransactions_xebayaccount',
			'vname' => 'LBL_EBAY_ACCOUNT',
			'source'=>'non-db',
		),
		'xebayorder_id'=>
		array(
			'name'=>'xebayorder_id',
			'vname'=>'LBL_ORDER_ID',
			'type' => 'id',
		),
		'xebayorder_name' => array(
			'name'=> 'xebayorder_name',
			'rname' => 'buyer_user_id',
			'vname'=>'LBL_RELATED_TO_ORDER',
			'id_name'=>'xebayorder_id',
			'type'=>'relate',
			'link'=>'xebayorder_link',
			'source'=>'non-db',
			'dbType' => 'varchar',
			'table' => 'xebayorders',
			'module' => 'xeBayOrders',
		),
		'xebayorder_link'=>
		array(
			'name' => 'xinventory_link',
			'type' => 'link',
			'relationship' => 'xebaytransactions_xebayorder',
			'vname' => 'LBL_RELATED_TO_ORDER',
			'source'=>'non-db',
		),
		'combine_order_id'=>
		array(
			'name'=>'combine_order_id',
			'vname'=>'LBL_COMBINE_ORDER_ID',
			'type' => 'id',
		),
		'stockout'=>
		array(
			'name'=>'stockout',
			'vname'=>'LBL_STOCKOUT',
			'type' => 'bool',
			'default'=>false,
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
            'required' => true,
		),
		'item_view_item_url' => array(
			'name' => 'item_view_item_url',
			'vname' => 'LBL_ITEM_VIEW_ITEM_URL',
			'type' => 'url',
			'len' => '255',
		),
		'xinventory_id' => array(
			'name'=>'xinventory_id',
			'vname'=>'LBL_ITEM_SKU',
			'type'=>'id',
		),
		'xinventory_name' => array(
			'name'=> 'xinventory_name',
			'rname' => 'name',
			'vname'=>'LBL_RELATED_TO_INVENTORY',
			'id_name'=>'xinventory_id',
			'type'=>'relate',
			'link'=>'xinventory_link',
			'source'=>'non-db',
			'dbType' => 'varchar',
			'table' => 'xinventories',
			'module' => 'xInventories',
		),
		'customs_declaration' => array(
			'name'=> 'customs_declaration',
			'rname' => 'subtitle',
			'vname'=>'LBL_CUSTOMS_DECLARATION',
			'id_name'=>'xinventory_id',
			'type'=>'relate',
			'link'=>'xinventory_link',
			'source'=>'non-db',
			'dbType' => 'varchar',
			'table' => 'xinventories',
			'module' => 'xInventories',
		),
		'width' => array(
			'name'=> 'width',
			'rname' => 'width',
			'vname'=>'LBL_WIDTH',
			'id_name'=>'xinventory_id',
			'type'=>'relate',
			'link'=>'xinventory_link',
			'source'=>'non-db',
			'dbType' => 'float',
			'table' => 'xinventories',
			'module' => 'xInventories',
		),
		'height' => array(
			'name'=> 'height',
			'rname' => 'height',
			'vname'=>'LBL_HEIGHT',
			'id_name'=>'xinventory_id',
			'type'=>'relate',
			'link'=>'xinventory_link',
			'source'=>'non-db',
			'dbType' => 'float',
			'table' => 'xinventories',
			'module' => 'xInventories',
		),
		'deep' => array(
			'name'=> 'deep',
			'rname' => 'deep',
			'vname'=>'LBL_DEEP',
			'id_name'=>'xinventory_id',
			'type'=>'relate',
			'link'=>'xinventory_link',
			'source'=>'non-db',
			'dbType' => 'float',
			'table' => 'xinventories',
			'module' => 'xInventories',
		),
		'weight' => array(
			'name'=> 'weight',
			'rname' => 'weight',
			'vname'=>'LBL_WEIGHT',
			'id_name'=>'xinventory_id',
			'type'=>'relate',
			'link'=>'xinventory_link',
			'source'=>'non-db',
			'dbType' => 'float',
			'table' => 'xinventories',
			'module' => 'xInventories',
		),
		'goods_allocation' => array(
			'name'=> 'goods_allocation',
			'rname' => 'goods_allocation',
			'vname'=>'LBL_GOODS_ALLOCATION',
			'id_name'=>'xinventory_id',
			'type'=>'relate',
			'link'=>'xinventory_link',
			'source'=>'non-db',
			'dbType' => 'varchar',
			'table' => 'xinventories',
			'module' => 'xInventories',
		),
		'xinventory_link'=>
		array(
			'name' => 'xinventory_link',
			'type' => 'link',
			'relationship' => 'xebaytransactions_xinventory',
			'vname' => 'LBL_RELATED_TO_INVENTORY',
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
		'xebaytransactions_xebayaccount' => array(
			'lhs_module'=> 'xeBayAccounts', 'lhs_table'=> 'xebayaccounts', 'lhs_key' => 'id',
			'rhs_module' => 'xeBayTransactions', 'rhs_table'=> 'xebaytransactions', 'rhs_key' => 'xebayaccount_id',
			'relationship_type'=>'one-to-many'),
		'xebaytransactions_xebayorder' => array(
			'lhs_module'=> 'xeBayOrders', 'lhs_table'=> 'xebayorders', 'lhs_key' => 'id',
			'rhs_module'=> 'xeBayTransactions', 'rhs_table'=> 'xebaytransactions', 'rhs_key' => 'xebayorder_id',
			'relationship_type'=>'one-to-many'),
		'xebaytransactions_xinventory' => array(
			'lhs_module'=> 'xInventories', 'lhs_table'=> 'xinventories', 'lhs_key' => 'id',
			'rhs_module' => 'xeBayTransactions', 'rhs_table'=> 'xebaytransactions', 'rhs_key' => 'xinventory_id',
			'relationship_type'=>'one-to-many'),
	),
	'optimistic_locking'=>true,
	'unified_search'=>true,
);

if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}

VardefManager::createVardef('xeBayTransactions','xeBayTransaction', array('basic','assignable'));
