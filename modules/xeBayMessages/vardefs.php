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

$dictionary['xeBayMessage'] = array(
	'table'=>'xebaymessages',
	'audited'=>true,
	'duplicate_merge'=>true,
	'fields'=>array (
		// ebay account
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
			'relationship' => 'xebaymessages_xebayaccount',
			'vname' => 'LBL_EBAY_ACCOUNT',
			'source'=>'non-db',
		),

		// Item
		'item_id' => array(
			'name' => 'item_id',
			'vname' => 'LBL_ITEM_ID',
			'type' => 'varchar',
			'len' => '20',
		),
		'currency_id' => array(
			'name' => 'currency_id',
			'vname' => 'LBL_CURRENCY_ID',
			'type' => 'varchar',
			'len' => '3',
		),
		'price' => array(
			'name' => 'price',
			'vname' => 'LBL_PRICE',
			'type' => 'double',
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
		'title' => array(
			'name' => 'title',
			'vname' => 'LBL_TITLE',
			'type' => 'varchar',
			'len' => '80',
		),

		//
		'creation_date' => array(
			'name' => 'creation_date',
			'vname' => 'LBL_CREATION_DATE',
			'type' => 'datetime',
		),
		
		//
		'message_status' => array(
			'name' => 'message_status',
			'vname' => 'LBL_MESSAGE_STATUS',
			'type' => 'varchar',
			'len' => '16',
		),

		// Question
		'name' => array (
			'name' => 'name',
			'vname' => 'LBL_SUBJECT',
			'type' => 'varchar',
			'len' => '255',
			'comment' => 'The subject of the email',
		),
		'description' => array (
			'name' => 'description',
			'vname' => 'LBL_DESCRIPTION',
			'type' => 'varchar',
			'len' => '4000',
			'comment' => 'body',
		),
		'message_id' => array (
			'name'		=> 'message_id',
			'vname' 	=> 'LBL_MESSAGE_ID',
			'type'		=> 'varchar',
			'len' => '20',
		),
		'message_type' => array (
			'name'		=> 'message_type',
			'vname' 	=> 'LBL_MESSAGE_TYPE',
			'type'		=> 'varchar',
			'len'		=> 64,
		),
		'question_type' => array (
			'name'		=> 'question_type',
			'vname' 	=> 'LBL_QUESTION_TYPE',
			'type'		=> 'varchar',
			'len'		=> 64,
		),
		'recipient_id' => array (
			'name'		=> 'recipient_id',
			'vname' 	=> 'LBL_RECIPIENT_ID',
			'type'		=> 'text',
		),
		'sender_email' => array (
			'name'		=> 'sender_email',
			'vname' 	=> 'LBL_SENDER_EMAIL',
			'type'		=> 'varchar',
			'len'		=> 64,
		),
		'sender_id' => array (
			'name'		=> 'sender_id',
			'vname' 	=> 'LBL_SENDER_ID',
			'type'		=> 'varchar',
			'len'		=> 64,
		),

		// responses
		'responses' => array (
			'name' => 'responses',
			'vname' => 'LBL_RESPONSES',
			'type' => 'text',
		),
		
		'flagged' => array (
			'name' => 'flagged',
			'vname' => 'LBL_FLAGGED',
			'type' => 'bool',
			'default' => false,
		),
		'read_status' => array (
			'name' => 'read_status',
			'vname' => 'LBL_READ_STATUS',
			'type' => 'bool',
			'default' => false,
		),
		'replied' => array (
			'name' => 'replied',
			'vname' => 'LBL_REPLIED',
			'type' => 'bool',
			'default' => false,
		),

		'date_sent' => array (
			'name'			=> 'date_sent',
			'vname'			=> 'LBL_DATE_SENT',
			'type'			=> 'datetime',
		),
	),
	'relationships'=>array (
		'xebaymessages_xebayaccount' => array(
			'lhs_module'=> 'xeBayAccounts', 'lhs_table'=> 'xebayaccounts', 'lhs_key' => 'id',
			'rhs_module' => 'xeBayMessagess', 'rhs_table'=> 'xebaymessages', 'rhs_key' => 'xebayaccount_id',
			'relationship_type'=>'one-to-many'),
	),
	'optimistic_locking'=>true,
	'unified_search'=>true,
);

if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}

VardefManager::createVardef('xeBayMessages','xeBayMessage', array('basic','assignable'));
