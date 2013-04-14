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

$dictionary['xPhotobucketMedia'] = array(
	'table'=>'xphotobucketmedias',
	'audited'=>true,
	'duplicate_merge'=>true,
	'fields'=>array (
		'xphotobucketaccount_id'=>
		array(
			'name'=>'xphotobucketaccount_id',
			'vname'=>'LBL_PHOTOBUCKET_ACCOUNT_ID',
			'type' => 'id',
		),
		'xphotobucketaccount_name'=>
		array(
			'name'=>'xphotobucketaccount_name',
			'rname' => 'name',
			'vname'=>'LBL_PHOTOBUCKET_ACCOUNT',
			'id_name'=>'xphotobucketaccount_id',
			'type'=>'relate',
			'link'=>'xphotobucketaccount_link',
			'reportable'=>false,
			'source'=>'non-db',
			'dbType' => 'varchar',
			'table' => 'xphotobucketaccounts',
			'module' => 'xPhotobucketAccounts',
			'required' => true,
		),
		'xphotobucketaccount_link'=>
		array(
			'name' => 'xphotobucketaccount_link',
			'type' => 'link',
			'relationship' => 'xphotobucketmedias_xphotobucketaccount',
			'vname' => 'LBL_PHOTOBUCKET_ACCOUNT',
			'source'=>'non-db',
		),
		'filename'=>
		array (
			'name' => 'filename',
			'vname' => 'LBL_FILENAME',
			'type' => 'file',
			'dbType' => 'varchar',
			'len' => '255',
			'reportable' => true,
			'importable' => false,
		),
		'browse_url'=>
		array (
			'name' => 'browse_url',
			'vname' => 'LBL_BROWSE_URL',
			'type' => 'url',
			'len' => '255',
		),
		'image_url'=>
		array (
			'name' => 'image_url',
			'vname' => 'LBL_IMAGE_URL',
			'type' => 'url',
			'len' => '255',
		),
		'thumb_url'=>
		array (
			'name' => 'thumb_url',
			'vname' => 'LBL_THUMB_URL',
			'type' => 'url',
			'len' => '255',
		),
	),
	'relationships'=>array (
		'xphotobucketmedias_xphotobucketaccount' => array(
			'lhs_module'=> 'xPhotobucketAccounts', 'lhs_table'=> 'xphotobucketaccounts', 'lhs_key' => 'id',
			'rhs_module'=> 'xPhotobucketMedias', 'rhs_table'=> 'xphotobucketmedias', 'rhs_key' => 'xphotobucketaccount_id',
			'relationship_type'=>'one-to-many'),
	),
	'optimistic_locking'=>true,
	'unified_search'=>true,
);

if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}

VardefManager::createVardef('xPhotobucketMedias','xPhotobucketMedia', array('basic','assignable'));
