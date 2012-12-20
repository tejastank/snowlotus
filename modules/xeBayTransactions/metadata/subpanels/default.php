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


$subpanel_layout = array(
	'top_buttons' => array(
		array('widget_class' => 'SubPanelTopCreateButton'),
	),

	'where' => '',

	'list_fields' => array(
		'sales_record_number'=>array(
			'vname' => 'LBL_SALES_RECORD_NUMBER',
			'widget_class' => 'SubPanelDetailViewLink',
	 		'width' => '10%',
		),
		'name'=>array(
	 		'vname' => 'LBL_NAME',
	 		'width' => '60%',
		),
		'item_view_item_url'=>array(
			'usage'=>'query_only',
		),
		'inventory_name'=>array(
	 		'vname' => 'LBL_RELATED_TO',
			'widget_class' => 'SubPanelDetailViewLink',
		 	'target_record_key' => 'item_sku',
			'target_module' => 'xInventories',
	 		'width' => '40%',
		),
		'price_currency_id'=>array(
			'vname' => 'LBL_PRICE_CURRENCY_ID',
	 		'width' => '10%',
		),
		'price_value' => array(
			'vname' => 'LBL_PRICE_VALUE',
	 		'width' => '10%',
		),
		'quantity_purchased' => array(
			'vname' => 'LBL_QUANTITY_PURCHASED',
	 		'width' => '10%',
		),
		'date_modified'=>array(
	 		'vname' => 'LBL_DATE_MODIFIED',
	 		'width' => '20%',
		),
		'edit_button'=>array(
			'widget_class' => 'SubPanelEditButton',
		 	'module' => 'xeBayTransactions',
	 		'width' => '4%',
		),
		'remove_button'=>array(
			'widget_class' => 'SubPanelRemoveButton',
		 	'module' => 'xeBayTransactions',
			'width' => '5%',
		),
	),
);

?>
