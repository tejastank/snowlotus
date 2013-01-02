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

$dictionary['xeBayCategory'] = array(
	'table'=>'xebaycategories',
	'audited'=>true,
	'duplicate_merge'=>true,
	'fields'=>array (
		'ebay_account_id'=>
		array(
			'name'=>'ebay_account_id',
	    	'vname'=> 'LBL_EBAY_ACCOUNT_ID',
	    	'type'=>'id',
		),
		'autopay_enabled'=>
		array(
			'name'=>'autopay_enabled',
	    	'vname'=> 'LBL_AUTOPAY_ENABLED',
	    	'type'=>'bool',
			'default'=>false,
		),
		'b2bvat_enabled'=>
		array(
			'name'=>'b2bvat_enabled',
	    	'vname'=> 'LBL_B2BVAT_ENABLED',
	    	'type'=>'bool',
			'default'=>false,
		),
		'bestoffer_enabled'=>
		array(
			'name'=>'bestoffer_enabled',
	    	'vname'=> 'LBL_BESTOFFER_ENABLED',
	    	'type'=>'bool',
			'default'=>false,
		),
		'category_id'=>
		array(
			'name'=>'category_id',
	    	'vname'=> 'LBL_CATEGORY_ID',
	    	'type'=>'varchar',
            'length'=>'10',
		),
        'category_level'=>
		array(
			'name'=>'category_level',
	    	'vname'=> 'LBL_CATEGORY_LEVEL',
	    	'type'=>'int',
		),
		'name'=>
		array(
			'name'=>'name',
	    	'vname'=> 'LBL_NAME',
	    	'type'=>'varchar',
            'length'=>'30',
			'comment' => 'category name',
		),
		'category_parent_id'=>
		array(
			'name'=>'category_parent_id',
	    	'vname'=> 'LBL_CATEGORY_PARENT_ID',
	    	'type'=>'varchar',
            'length'=>'10',
		),
		'expired'=>
		array(
			'name'=>'expired',
	    	'vname'=> 'LBL_EXPIRED',
	    	'type'=>'bool',
			'default'=>false,
		),
		'intl_autos_fixed_cat'=>
		array(
			'name'=>'intl_autos_fixed_cat',
	    	'vname'=> 'LBL_INTL_AUTOS_FIXED_CAT',
	    	'type'=>'bool',
			'default'=>false,
		),
		'leaf_category'=>
		array(
			'name'=>'leaf_category',
	    	'vname'=> 'LBL_LEAF_CATEGORY',
	    	'type'=>'bool',
			'default'=>false,
		),
		'lsd'=>
		array(
			'name'=>'lsd',
	    	'vname'=> 'LBL_LSD',
	    	'type'=>'bool',
			'default'=>false,
		),
		'orpa'=>
		array(
			'name'=>'orpa',
	    	'vname'=> 'LBL_ORPA',
	    	'type'=>'bool',
			'default'=>false,
		),
		'orra'=>
		array(
			'name'=>'orra',
	    	'vname'=> 'LBL_ORRA',
	    	'type'=>'bool',
			'default'=>false,
		),
		'seller_guarantee_eligible'=>
		array(
			'name'=>'seller_guarantee_eligible',
	    	'vname'=> 'LBL_SELLER_GUARANTEE_ELIGIBLE',
	    	'type'=>'bool',
			'default'=>false,
		),
		'virtual'=>
		array(
			'name'=>'virtual',
	    	'vname'=> 'LBL_VIRTUAL',
	    	'type'=>'bool',
			'default'=>false,
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

VardefManager::createVardef('xeBayCategories','xeBayCategory', array('basic','assignable'));
