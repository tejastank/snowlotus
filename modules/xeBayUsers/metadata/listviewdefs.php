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




$listViewDefs['xeBayUsers'] = array(
	'NAME' => array(
		'width' => '24', 
		'label' => 'LBL_NAME', 
		'sortable' => false,
		'default' => true,
        'link' => true),
	'SELLERLEVEL' => array( 
		'width' => '16', 
		'label' => 'LBL_SELLERLEVEL', 
		'default' => false,),
	'STORENAME' => array( 
		'width' => '32', 
		'label' => 'LBL_STORENAME', 
		'customCode' => '<a href="{$STOREURL}" title="" target="_blank">Visit my store ({$FEEDBACKSCORE})</a>',
    	'related_fields' => array(
			'0' => 'storeurl',
			'1' => 'feedbackscore',
		),
		'sortable' => false,
		'default' => true,),
	'SITE' => array( 
		'width' => '16', 
		'label' => 'LBL_SITE', 
		'default' => true,),
	'REGISTRATIONDATE' => array( 
		'width' => '16', 
		'label' => 'LBL_REGISTRATIONDATE', 
		'default' => true,),
	'DATE_MODIFIED' => array( 
		'width' => '16', 
		'label' => 'LBL_DATE_MODIFIED', 
		'default' => true,),
	'SYNC_USER_DATA' => array(
		'width' => '8',
		'label' => 'LBL_SYNC',
		'sortable' => false,
		'default' => true,),
);
?>
