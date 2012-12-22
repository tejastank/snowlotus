<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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




$listViewDefs['xeBayOrders'] = array(
	'SALES_RECORD_NUMBER' => array(
		'width' => '4', 
		'label' => 'LBL_SALES_RECORD_NUMBER', 
		'default' => true,
        'link' => true),         
	'BUYER_USER_ID' => array(
		'width' => '25', 
		'label' => 'LBL_BUYER_USER_ID', 
		'customCode' => '{$ORDER_DETAILS}',
    	'related_fields' => array(
		),
		'default' => true),         
	'SUBTOTAL_VALUE' => array(
		'width' => '4', 
		'label' => 'LBL_SUBTOTAL_VALUE', 
		'customCode' => '{$SUBTOTAL_CURRENCY_ID}&nbsp{$SUBTOTAL_VALUE}',
    	'related_fields' => array(
			'0' => 'subtotal_currency_id',
		),
		'default' => true),         
	'TOTAL_VALUE' => array(
		'width' => '4', 
		'label' => 'LBL_TOTAL_VALUE', 
		'customCode' => '{$TOTAL_CURRENCY_ID}&nbsp{$TOTAL_VALUE}',
    	'related_fields' => array(
			'0' => 'total_currency_id',
		),
		'default' => true),         
	'COUNTRY_NAME' => array(
		'width' => '4', 
		'label' => 'LBL_COUNTRY', 
		'default' => true),         
	'BUYER_CHECKOUT_MESSAGE' => array(
		'width' => '2', 
		'label' => 'LBL_BUYER_CHECKOUT_MESSAGE', 
		'default' => true),         
	'PRINT_STATUS' => array(
		'width' => '2', 
		'label' => 'LBL_PRINT_STATUS', 
		'customCode' => '{$PRINT_STATUS_ICON}',
		'default' => true),         
);
?>
