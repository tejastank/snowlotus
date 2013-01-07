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

$dictionary['xInventoryRecord'] = array(
	'table'=>'xinventoryrecords',
	'audited'=>true,
	'duplicate_merge'=>true,
	'fields'=>array (
		'xinventory_id'=>
		array(
			'name'=>'xinventory_id',
			'vname'=>'LBL_INVENTORY',
			'type'=>'id',
			'required' => true,
		),
		'xinventory_name'=>
		array(
			'name'=>'xinventory_name',
			'rname' => 'name',
			'vname'=>'LBL_INVENTORY',
			'id_name'=>'xinventory_id',
			'type'=>'relate',
			'link'=>'xinventory_link',
			'reportable'=>false,
			'source'=>'non-db',
			'dbType' => 'varchar',
			'table' => 'xinventories',
			'module' => 'xInventories',
		),
		'xinventory_link'=>
		array(
			'name' => 'inventory_link',
			'type' => 'link',
			'relationship' => 'xinventoryrecords_xinventory',
			'vname' => 'LBL_INVENTORY',
			'source'=>'non-db',
		),
        'operation'=>
		array(
			'name'=>'operation',
			'vname'=>'LBL_INVENTORY_MANAGEMENT',
			'type'=>'varchar',
	    	'len'=>5,
			'required' => true,
			'audited' => true,
			'comment' => 'value: in, out'
		),
		'price'=>
		array(
			'name'=>'price',
	    	'vname'=> 'LBL_PRICE',
	    	'type'=>'double',
			'audited' => true,
		),
		'quantity'=>
		array(
			'name'=>'quantity',
	    	'vname'=> 'LBL_QUANTITY',
	    	'type'=>'int',
			'audited' => true,
			'required' => true,
		),
		'vendor_id'=>
		array(
			'name'=>'vendor_id',
			'vname'=>'LBL_VENDOR_ID',
			'type' => 'id',
		),
        'parent_type'=>
        array(
            'name'=>'parent_type',
            'vname'=>'LBL_PARENT_TYPE',
            'type' =>'parent_type',
            'dbType' => 'varchar',
            'group'=>'parent_name',
            'options'=> 'parent_type_display',
            'len'=> '255',
        ),
        'parent_id'=>
        array(
            'name'=>'parent_id',
            'vname'=>'LBL_PARENT_ID',
            'type'=>'id',
            'required'=>false,
            'reportable'=>true,
            'comment' => 'The ID of the record specified in parent_type'
        ),
        'parent_name'=>
        array(
            'name'=> 'parent_name',
            'parent_type'=>'record_type_display',
            'type_name'=>'parent_type',
            'id_name'=>'parent_id',
            'vname'=>'LBL_RELATED_TO',
            'type'=>'parent',
            'source'=>'non-db',
            'options'=> 'record_type_display_notes',
        ),
	),
	'relationships'=>array (
		'xinventoryrecords_xinventory' => array(
			'lhs_module'=> 'xInventories', 'lhs_table'=> 'xinventories', 'lhs_key' => 'id',
			'rhs_module' => 'xInventoryRecords', 'rhs_table'=> 'xinventoryrecords', 'rhs_key' => 'xinventory_id',
			'relationship_type'=>'one-to-many'),
	),
    'indices' => array (
        array('name' =>'idx_inventory_record_parent', 'type'=>'index', 'fields'=>array('parent_id', 'parent_type')),
    ),
	'optimistic_locking'=>true,
	'unified_search'=>true,
);

if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}

VardefManager::createVardef('xInventoryRecords','xInventoryRecord', array('basic','assignable'));
