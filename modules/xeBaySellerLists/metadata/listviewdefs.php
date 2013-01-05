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




$listViewDefs['xeBaySellerLists'] = array(
	'ITEM_ID' => array(
		'width' => '12', 
		'label' => 'LBL_PICTURE', 
		'default' => true,
		'customCode' => '<a title="{$ITEM_ID}" href="{$VIEW_ITEM_URL}" target="_blank"><img src="http://thumbs3.ebaystatic.com/pict/{$ITEM_ID}6464.jpg" alt="" /></a>',
		'sortable' => false,
    	'related_fields' => array(
			'0' => 'view_item_url',
		),
	),
	'NAME' => array(
		'width' => '80', 
		'label' => 'LBL_NAME', 
		'default' => true,
        'link' => true,
		'sortable' => false
	), 
	'INVENTORY_NAME' => array (
		'width' => '50',
		'label' => 'LBL_LIST_RELATED_TO',
		'module' => 'xInventories',
		'id' => 'INVENTORY_ID',
		'default' => true,
		'related_fields' => 
		array (
			0 => 'inventory_id',
		),
	),
	'LISTING_TYPE' => array(
		'width' => '18', 
		'label' => 'LBL_LISTING_TYPE', 
		'default' => true,
		'customCode' => '{$LISTING_TYPE_ICON}',
	),
	'PRICE' => array(
		'width' => '14', 
		'label' => 'LBL_PRICE', 
		'default' => true,
		'customCode' => '{$CURRENCY_ID}&nbsp{$PRICE}',
    	'related_fields' => array(
			'0' => 'currency_id',
		),
	),
	'QUANTITY' => array(
		'width' => '14', 
		'label' => 'LBL_QUANTITY', 
		'default' => true,
	),
	'HITCOUNT' => array(
		'width' => '18', 
		'label' => 'LBL_HITCOUNT', 
		'default' => true,
	),
	'VARIATION' => array(
		'width' => '18', 
		'label' => 'LBL_VARIATION', 
		'default' => true,
	),
);
?>
