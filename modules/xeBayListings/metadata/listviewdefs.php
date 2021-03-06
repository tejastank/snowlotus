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




$listViewDefs['xeBayListings'] = array(
	'ASSOCIATION' => array(
		'width' => '12',
		'label' => 'LBL_ASSOCIATION',
		'default' => true),
	'LISTING_STATUS' => array(
		'width' => '14',
		'label' => 'LBL_LISTING_STATUS',
		'default' => true),
	'ITEM_ID' => array(
		'width' => '8',
		'label' => 'LBL_PICTURE',
		'default' => true,
		'customCode' => '<a title="{$ITEM_ID}" href="{$VIEW_ITEM_URL}" target="_blank"><img src="http://thumbs3.ebaystatic.com/pict/{$ITEM_ID}8080.jpg" alt="" width="80" height="80"/></a>',
		'sortable' => false,
		'related_fields' => array(
				'0' => 'view_item_url',
		),
	),
	'NAME' => array(
		'width' => '24',
		'label' => 'LBL_NAME',
		'default' => true,
        'link' => true),         
	'SHORT_TITLE' => array(
		'width' => '24', 
		'label' => 'LBL_SHORT_TITLE', 
		'default' => true),         
	'XINVENTORY_NAME' => array(
		'width' => '24', 
		'label' => 'LBL_INVENTORY', 
		'module' => 'xInventories',
        'id' => 'XINVENTORY_ID',
		'default' => true,
		'related_fields' => 
		array (
			0 => 'xinventory_id',
		),
	),
	'ID' => array(
		'width' => '24',
		'label' => 'LBL_ID',
		'default' => true,
	),
	'LISTING_TYPE' => array(
		'width' => '12',
		'label' => 'LBL_LISTING_TYPE',
		'default' => true,
		'customCode' => '{$LISTING_TYPE_ICON}',
	),
	'STARTPRICE' => array(
		'width' => '12',
		'label' => 'LBL_PRICE',
		'default' => true,
		'customCode' => 'USD&nbsp{$STARTPRICE}',
	),
	'QUANTITY' => array(
		'width' => '12',
		'label' => 'LBL_QUANTITY',
		'default' => true,
	),
	'HITCOUNT' => array(
		'width' => '12',
		'label' => 'LBL_HITCOUNT',
		'default' => true,
	),
	'STARTTIME' => array(
		'width' => '14',
		'label' => 'LBL_STARTTIME',
		'default' => true,
	),
	'DATE_MODIFIED' => array (
		'width' => '14',
		'label' => 'LBL_DATE_MODIFIED',
		'default' => true,
	),
	'DATE_ENTERED' => array (
	    'width' => '14',
	    'label' => 'LBL_DATE_ENTERED',
	    'default' => true,
	), 
	'PREVIEW' => array(
		'width' => '1', 
		'label' => 'LBL_PREVIEW', 
		'customCode' => '{$PREVIEW_URL}',
		'default' => true,
		'sortable' => false,
	),
);
?>
