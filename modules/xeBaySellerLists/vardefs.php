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

$dictionary['xeBaySellerList'] = array(
	'table'=>'xebaysellerlists',
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
			'relationship' => 'xebaysellerlists_xebayaccount',
			'vname' => 'LBL_EBAY_ACCOUNT',
			'source'=>'non-db',
		),
        'xebaylisting_id' =>
		array(
			'name'=>'xebaylisting_id',
			'vname'=>'LBL_EBAY_LISING_ID',
			'type' => 'id',
            'comment' => 'Application Data',
		),
		'xebaylisting_name'=>
		array(
			'name'=>'xebaylisting_name',
			'rname' => 'name',
			'vname'=>'LBL_EBAY_LISTING',
			'id_name'=>'xebaylisting_id',
			'type'=>'relate',
			'link'=>'xebaylisting_link',
			'reportable'=>false,
			'source'=>'non-db',
			'dbType' => 'varchar',
			'table' => 'xebaylistings',
			'module' => 'xeBayListings',
		),
		'xebaylisting_link'=>
		array(
			'name' => 'xebaylisting_link',
			'type' => 'link',
			'relationship' => 'xebaysellerlists_xebaylisting',
			'vname' => 'LBL_EBAY_LISTING',
			'link_type' => 'one',
			'module' => 'xeBayListings',
			'bean_name' => 'xeBayListing',
			'source'=>'non-db',
		),
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
		'picture_details' => array(
			'name' => 'picture_details',
			'vname' => 'LBL_PICTURE_DETAILS',
			'type' => 'text',
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
		'xinventory_id' => array(
			'name'=>'xinventory_id',
			'vname'=>'LBL_SKU',
			'type'=>'id',
		),
		'xinventory_name' => array(
			'name'=> 'xinventory_name',
			'rname' => 'name',
			'vname'=>'LBL_XINVENTORY',
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
			'relationship' => 'xbaysellerlists_xinventory',
			'vname' => 'LBL_RELATED_TO',
			'source'=>'non-db',
		),
	),
	'relationships'=>array (
		'xebaysellerlists_xebayaccount' => array(
			'lhs_module'=> 'xeBayAccounts', 'lhs_table'=> 'xebayaccounts', 'lhs_key' => 'id',
			'rhs_module' => 'xeBaySellerLists', 'rhs_table'=> 'xebaysellerlists', 'rhs_key' => 'xebayaccount_id',
			'relationship_type'=>'one-to-many'),
		'xebaysellerlists_xebaylisting' => array(
			'lhs_module'=> 'xeBayListings', 'lhs_table'=> 'xebaylistings', 'lhs_key' => 'id',
			'rhs_module' => 'xeBaySellerLists', 'rhs_table'=> 'xebaysellerlists', 'rhs_key' => 'xebaylisting_id',
			'relationship_type'=>'one-to-one'),
		'xbaysellerlists_xinventory' => array(
			'lhs_module'=> 'xInventories', 'lhs_table'=> 'xinventories', 'lhs_key' => 'id',
			'rhs_module' => 'xeBaySellerLists', 'rhs_table'=> 'xebaysellerlists', 'rhs_key' => 'xinventory_id',
			'relationship_type'=>'one-to-many'),
	),
	'optimistic_locking'=>true,
	'unified_search'=>true,
);

if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}

VardefManager::createVardef('xeBaySellerLists','xeBaySellerList', array('basic','assignable'));
