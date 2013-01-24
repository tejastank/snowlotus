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

$dictionary['xeBaySellerSurvey'] = array(
	'table'=>'xebaysellersurveys',
	'audited'=>true,
	'duplicate_merge'=>true,
	'fields'=>array (
        'userid' => array(
			'name' => 'userid',
			'vname' => 'LBL_USERID',
			'type' => 'varchar',
			'len' => '32',
		),
		'buyitnowprice' => array(
			'name' => 'buyitnowprice',
			'vname' => 'LBL_BUYITNOWPRICE',
			'type' => 'double',
		),
		'buyitnowprice_currencyid' => array(
			'name' => 'buyitnowprice_currencyid',
			'vname' => 'LBL_BUYITNOWPRICE_CURRENCYID',
			'type' => 'varchar',
			'len' => '3',
		),
		'itemid' => array(
			'name' => 'itemid',
			'vname' => 'LBL_ITEMID',
			'type' => 'varchar',
			'len' => '20',
		),
		'convertedstartprice' => array(
			'name' => 'convertedstartprice',
			'vname' => 'LBL_CONVERTEDSTARTPRICE',
			'type' => 'varchar',
			'len' => '3',
		),
		'convertedstartprice_currencyid' => array(
			'name' => 'convertedstartprice_currencyid',
			'vname' => 'LBL_CONVERTEDSTARTPRICE_CURRENCYID',
			'type' => 'double',
		),
		'starttime' => array(
			'name' => 'starttime',
			'vname' => 'LBL_STARTTIME',
			'type' => 'datetime',
		),
		'endtime' => array(
			'name' => 'endtime',
			'vname' => 'LBL_ENDTIME',
			'type' => 'datetime',
		),
		'viewitemurl' => array(
			'name' => 'viewitemurl',
			'vname' => 'LBL_VIEWITEMURL',
			'type' => 'url',
			'len' => '255',
		),
		'picturedetails' => array(
			'name' => 'picturedetails',
			'vname' => 'LBL_PICTUREDETAILS',
			'type' => 'text',
		),
		'categoryid' => array(
			'name' => 'categoryid',
			'vname' => 'LBL_CATEGORYID',
			'type' => 'varchar',
			'len' => '10',
		),
		'categoryname' => array(
			'name' => 'categoryname',
			'vname' => 'LBL_CATEGORYNAME',
			'type' => 'varchar',
			'len' => '128',
		),
		'quantity' => array(
			'name' => 'quantity',
			'vname' => 'LBL_QUANTITY',
			'type' => 'int',
		),
		'quantitysold' => array(
			'name' => 'quantitysold',
			'vname' => 'LBL_QUANTITYSOLD',
			'type' => 'int',
		),
		'quantitysold_permonth' => array(
			'name' => 'quantitysold_permonth',
			'vname' => 'LBL_QUANTITYSOLD_PERMONTH',
			'type' => 'int',
		),
		'startprice' => array(
			'name' => 'startprice',
			'vname' => 'LBL_STARTPRICE',
			'type' => 'double',
		),
		'startprice_currencyid' => array(
			'name' => 'startprice_currencyid',
			'vname' => 'LBL_STARTPRICE_CURRENCYID',
			'type' => 'varchar',
			'len' => '3',
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

VardefManager::createVardef('xeBaySellerSurveys','xeBaySellerSurvey', array('basic','assignable'));
