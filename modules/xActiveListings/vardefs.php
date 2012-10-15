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

$dictionary['xActiveListing'] = array(
	'table'=>'xactivelistings',
	'audited'=>true,
	'duplicate_merge'=>true,
	'fields'=>array (
		'hitcount' => array(
			'name' => 'hitcount',
			'vname' => 'LBL_HITCOUNT',
			'type' => 'int',
		),
		'item_id' => array(
			'name' => 'item_id',
			'vname' => 'LBL_ITEM_ID',
			'type' => 'varchar',
			'len' => '20',
			'importable' => 'required',
            'required' => true
		),
		'currency_id' => array(
			'name' => 'currency_id',
			'vname' => 'LBL_CURRENCY_ID',
			'type' => 'varchar',
			'len' => '3',
			'importable' => 'required',
            'required' => true
		),
		'price' => array(
			'name' => 'price',
			'vname' => 'LBL_PRICE',
			'type' => 'double',
			'importable' => 'required',
            'required' => true
		),
		'endtime' => array(
			'name' => 'endtime',
			'vname' => 'LBL_ENDTIME',
			'type' => 'datetime',
		),
		'view_item_url' => array(
			'name' => 'view_item_url',
			'vname' => 'LBL_VIEW_ITEM_URL',
			'type' => 'url',
			'len' => '255',
		),
		'listing_type' => array(
			'name' => 'listing_type',
			'vname' => 'LBL_LISTING_TYPE',
			'type' => 'varchar',
			'len' => '32',
			'importable' => 'required',
            'required' => true
		),
		'bid_count' => array(
			'name' => 'bid_count',
			'vname' => 'LBL_BID_COUNT',
			'type' => 'int',
			'default' => 0,
		),
		'quantity' => array(
			'name' => 'quantity',
			'vname' => 'LBL_QUANTITY',
			'type' => 'int',
		),
		'sku' => array(
			'name' => 'sku',
			'vname' => 'LBL_SKU',
			'type' => 'varchar',
			'len' => '50',
		),
		'name' => array(
			'name' => 'name',
			'vname' => 'LBL_NAME',
			'type' => 'varchar',
			'len' => '80',
			'importable' => 'required',
            'required' => true
		),
		'variation' => array(
			'name' => 'variation',
			'vname' => 'LBL_VARIATION',
			'type' => 'bool',
			'default' => false,
		),
		'notes' => array (
			'name' => 'notes',
			'type' => 'link',
			'relationship' => 'xactivelistings_notes',
			'source'=>'non-db',
			'vname'=>'LBL_NOTES',
		),
		'parent_type' => array(
			'name'=>'parent_type',
			'vname'=>'LBL_PARENT_TYPE',
			'type' =>'parent_type',
			'dbType' => 'varchar',
			'group'=>'parent_name',
			'options'=> 'parent_type_display',
			'len'=> '255',
		),
		'parent_id' => array(
			'name'=>'parent_id',
			'vname'=>'LBL_PARENT_ID',
			'type'=>'id',
			'required'=>false,
			'reportable'=>true,
		),
		'parent_name' => array(
			'name'=> 'parent_name',
			'parent_type'=>'record_type_display',
			'type_name'=>'parent_type',
			'id_name'=>'parent_id',
			'vname'=>'LBL_RELATED_TO',
			'type'=>'parent',
			'source'=>'non-db',
			'options'=> 'xinventories_type_display',
		),
	),
	'relationships'=>array (
		'xactivelistings_notes' => array('lhs_module'=> 'xActiveListings', 'lhs_table'=> 'xactivelistings', 'lhs_key' => 'id',
								'rhs_module'=> 'Notes', 'rhs_table'=> 'notes', 'rhs_key' => 'parent_id',
								'relationship_type'=>'one-to-many', 'relationship_role_column'=>'parent_type',
								'relationship_role_column_value'=>'xActiveListings'),
	),
	'optimistic_locking'=>true,
	'unified_search'=>true,
);

if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}

VardefManager::createVardef('xActiveListings','xActiveListing', array('basic','assignable'));
