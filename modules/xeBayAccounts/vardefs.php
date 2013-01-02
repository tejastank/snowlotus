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

$dictionary['xeBayAccount'] = array(
	'table'=>'xebayaccounts',
	'audited'=>true,
	'duplicate_merge'=>true,
	'fields'=>array (
		'ebay_auth_token'=>
		array (
			'name' => 'ebay_auth_token',
			'vname' => 'LBL_EBAY_AUTH_TOKEN',
			'type' => 'text',
		),
		'hard_expiration_time'=>
		array (
			'name' => 'hard_expiration_time',
			'vname' => 'LBL_HARD_EXPIRATION_TIME',
	    	'type'=>'datetime',
		),
		// Use GeteBayDetails to retrieve the available meta-data for the specified eBay site.
		'ebay_details'=>
		array (
			'name' => 'ebay_details',
			'vname' => 'LBL_EBAY_DETAILS',
			'type' => 'varchar',
			'len' => 255,
		),
		'ebay_detail_update_time' => array(
			'name' => 'ebay_detail_update_time',
			'vname' => 'LBL_EBAY_DETAIL_UPDATE_TIME',
			'type' => 'datetime',
		),
		// Category meta-data
		'category_count'=>
		array (
			'name' => 'category_count',
			'vname' => 'LBL_CATEGORY_COUNT',
			'type' => 'int',
		),
		'category_version'=>
		array (
			'name' => 'category_version',
			'vname' => 'LBL_CATEGORY_VERSION',
			'type' => 'varchar',
			'len' => 32,
		),
		'minimum_reserve_price'=>
		array (
			'name' => 'minimum_reserve_price',
			'vname' => 'LBL_MINIMUM_RESERVE_PRICE',
			'type' => 'double',
		),
		'reduce_reserve_allowed'=>
		array (
			'name' => 'reduce_reserve_allowed',
			'vname' => 'LBL_REDUCE_RESERVE_ALLOWED',
			'type' => 'bool',
		),
		'reserve_price_allowed'=>
		array (
			'name' => 'reserve_price_allowed',
			'vname' => 'LBL_RESERVE_PRICE_ALLOWED',
			'type' => 'bool',
		),
		'category_update_time'=>
		array (
			'name' => 'category_update_time',
			'vname' => 'LBL_CATEGORY_UPDATE_TIME',
			'type' => 'datetime',
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

VardefManager::createVardef('xeBayAccounts','xeBayAccount', array('basic','assignable'));
