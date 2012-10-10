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

$dictionary['xInventory'] = array(
	'table'=>'xinventories',
	'audited'=>true,
	'duplicate_merge'=>true,
	'fields'=>array (
		'subtitle'=>
		array(
			'name'=>'subtitle',
	    	'vname'=> 'LBL_SUBTITLE',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>55,
		),
		'category_id'=>
		array(
			'name'=>'category_id',
			'vname'=>'LBL_CATEGORY',
			'type' => 'id',
			'required' => false,
			'audited' => true,
			'reportable'=>false,
		),
		'category_name'=>
		array(
			'name'=>'category_name',
			'rname' => 'name',
			'vname'=>'LBL_CATEGORY',
			'id_name'=>'category_id',
			'type'=>'relate',
			'link'=>'category_link',
			'reportable'=>false,
			'source'=>'non-db',
			'dbType' => 'varchar',
			'table' => 'xcategories',
			'module' => 'xCategories',
		),
		'category_link'=>
		array(
			'name' => 'category_link',
			'type' => 'link',
			'relationship' => 'xinventory_xcategory',
			'vname' => 'LBL_CATEGORY',
			'source'=>'non-db',
		),
		'price'=>
		array(
			'name'=>'price',
	    	'vname'=> 'LBL_PRICE',
	    	'type'=>'double',
			'audited' => true,
		),
		'weight'=>
		array(
			'name'=>'weight',
	    	'vname'=> 'LBL_WEIGHT',
	    	'type'=>'float',
		),
		'weight_unit'=>
		array(
			'name'=>'weight_unit',
	    	'vname'=> 'LBL_WEIGHT_UNIT',
	    	'type'=>'enum',
			'options'=>'weight_unit_dom',
		),
		'quantity'=>
		array(
			'name'=>'quantity',
	    	'vname'=> 'LBL_QUANTITY',
	    	'type'=>'int',
			'audited' => true,
		),
		'inventory_cap'=>
		array(
			'name'=>'inventory_cap',
	    	'vname'=> 'LBL_INVENTORY_CAP',
	    	'type'=>'int',
		),
		'inventory_floor'=>
		array(
			'name'=>'inventory_floor',
	    	'vname'=> 'LBL_INVENTORY_FLOOR',
	    	'type'=>'int',
		),
		'goods_allocation'=>
		array(
			'name'=>'goods_allocation',
	    	'vname'=> 'LBL_GOODS_ALLOCATION',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>5,
			'audited' => true,
		),
		'sku'=>
		array(
			'name'=>'sku',
	    	'vname'=> 'LBL_SKU',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>50,
		),
		'description'=>
		array (
			'name' => 'description',
			'vname' => 'LBL_DESCRIPTION',
			'type' => 'text',
		),
		'body' => array(
			'name' => 'body',
			'vname' => 'LBL_PLAIN_TEXT',
			'type' => 'text',
			'comment' => 'Plain text body to be used in resulting email'
		),
		'body_html' => array(
			'name' => 'body_html',
			'vname' => 'LBL_BODY',
			'type' => 'html',
			'comment' => 'HTML formatted email body to be used in resulting email'
		),
		'body_tpl_id'=>
		array(
			'name'=>'body_tpl_id',
			'vname'=>'LBL_BODY_TEMPLATE',
			'type' => 'id',
			'required' => false,
			'audited' => true,
			'reportable'=>false,
		),
	),
	'relationships'=>array (
		'xinventory_xcategory' => array(
			'lhs_module'=> 'xCategories', 'lhs_table'=> 'xcategories', 'lhs_key' => 'id',
			'rhs_module' => 'xInventories', 'rhs_table'=> 'xinventories', 'rhs_key' => 'category_id',
			'relationship_type'=>'one-to-many'),
	),
	'optimistic_locking'=>true,
	'unified_search'=>true,
);

if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}

VardefManager::createVardef('xInventories','xInventory', array('basic','assignable'));
