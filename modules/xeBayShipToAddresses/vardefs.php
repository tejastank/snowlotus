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

$dictionary['xeBayShipToAddress'] = array(
	'table'=>'xebayshiptoaddresses',
	'audited'=>true,
	'duplicate_merge'=>true,
	'fields'=>array (
		'name'=>
		array(
			'name'=>'name',
	    	'vname'=> 'LBL_NAME',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>128,
		),
		'street1'=>
		array(
			'name'=>'street1',
	    	'vname'=> 'LBL_STREET1',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>512,
		),
		'street2'=>
		array(
			'name'=>'street2',
	    	'vname'=> 'LBL_STREET2',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>512,
		),
		'city_name'=>
		array(
			'name'=>'city_name',
	    	'vname'=> 'LBL_CITY_NAME',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>128,
		),
		'state_or_province'=>
		array(
			'name'=>'state_or_province',
	    	'vname'=> 'LBL_STATE_OR_PROVINCE',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>128,
		),
		'country'=>
		array(
			'name'=>'country',
	    	'vname'=> 'LBL_COUNTRY',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>12,
		),
		'country_name'=>
		array(
			'name'=>'country_name',
	    	'vname'=> 'LBL_COUNTRY_NAME',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>128,
		),
		'phone'=>
		array(
			'name'=>'phone',
	    	'vname'=> 'LBL_PHONE',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>128,
		),
		'postal_code'=>
		array(
			'name'=>'postal_code',
	    	'vname'=> 'LBL_POSTAL_CODE',
	    	'type'=>'name',
			'dbType' => 'varchar',
	    	'len'=>24,
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
	),
	'relationships'=>array (
	),
	'optimistic_locking'=>true,
	'unified_search'=>true,
);

if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}

VardefManager::createVardef('xeBayShipToAddresses','xeBayShipToAddress', array('basic','assignable'));
