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


require_once('include/MVC/View/views/view.list.php');

class xeBayOrdersViewList extends ViewList
{
	var $filter;

	function xeBayOrdersViewList()
	{
		$this->filter = $_REQUEST['filter'];
		if (empty($this->filter))
			$this->filter = 'unhandled';

        parent:: ViewList();
    }

	function listViewPrepare()
	{
		$this->where = "handled_status='{$this->filter}'";

		parent::listViewPrepare();
	}

	function listViewProcess()
 	{
		parent::listViewProcess();
	}

	function buildLinks($confirmation, $entryPoint, $label)
	{
		global $app_strings, $mod_strings;

		$js = <<<EOF
if (confirm('{$mod_strings[$confirmation]}' + sugarListView.get_num_selected() + '{$app_strings['NTC_DELETE_SELECTED_RECORDS']}')) {
	return sListView.send_form(true, 'xeBayOrders', 'index.php?entryPoint={$entryPoint}', '{$app_strings['LBL_LISTVIEW_NO_SELECTED']}');
}
return false;
EOF;

		$js = str_replace(array("\r","\n"),'',$js);

		return "<a href='javascript:void(0)' id=\"suspend_listview\" onclick=\"$js\">{$mod_strings[$label]}</a>";
	}

 	function preDisplay()
 	{
 		parent::preDisplay();

		$this->showMassupdateFields = false;

		$items = array();

		if ($this->filter == 'unhandled') {
			$items[] = $this->buildLinks('LBL_SHIPPING_MARK_CONFIRMATION', 'shippingMark', 'LBL_SHIPPING_MARK');
			$items[] = $this->buildLinks('LBL_PRINT_CONFIRMATION', 'print', 'LBL_PRINT_SELECT');
			$items[] = $this->buildLinks('LBL_SUSPEND_CONFIRMATION', 'suspend', 'LBL_SUSPEND');
		}

		if ($this->filter == 'handled') {
			$items[] = $this->buildLinks('LBL_REDELIVER_CONFIRMATION', 'redeliver', 'LBL_REDELIVER');
			$items[] = $this->buildLinks('LBL_UNHANDLED_MARK_CONFIRMATION', 'unhandledMark', 'LBL_MARK_AS_UNHANDLED');
		}

		if ($this->filter == 'suspended') {
			$items[] = $this->buildLinks('LBL_RESUME_CONFIRMATION', 'resume', 'LBL_RESUME');
		}

		$this->lv->actionsMenuExtraItems = $items;
 	}

	function display()
	{
		global $mod_strings, $sugar_config;

		$bean = BeanFactory::getBean('xeBayAccounts');
        $ebay_account_options =  "<select name='ebay_account_name' id='ebay_account_name' title=''>";
		$resp = $bean->get_list("", "ebay_auth_token<>''", 0, -1, -1, 0, false, array('name'));
		if ($resp['row_count'] > 0) {
			$ebay_account_options =  "<select name='ebay_account_name' id='ebay_account_name' title=''>";
			if ($resp['row_count'] > 1)
				$ebay_account_options .= "<option value='All'>All</option>";
			foreach($resp['list'] as &$account) {
				$name = $account->name;
				$ebay_account_options .= "<option value='$name'>$name</option>";
			}
		}
        $ebay_account_options .=  "</select>";

		$express_carrier_options = get_select_options_with_id(getExpressCarrierDropDown(), isset($sugar_config['ebay_express_carrier']) ? $sugar_config['ebay_express_carrier'] : 'default');

		$shortcuts_unhandled = <<<EOF
<script>
var OO = {};
OO.get = YAHOO.util.Dom.get;
OO.importorderDialog = false;	
OO.toggle_importorder = function (){
	var sd = OO.get("importorder_dialog");
	if(!OO.importorderDialog){	
		OO.importorderDialog = new YAHOO.widget.Dialog("importorder_dialog",{
			  	fixedcenter: true,
			  	draggable: false,
			  	visible : false, 
			 	modal : true,
			  	close: true
		});
		var listeners = new YAHOO.util.KeyListener(document, { keys : 27 }, {fn: function() { OO.importorderDialog.cancel();} } );
		OO.importorderDialog.cfg.queueProperty("keylisteners", listeners);
	}
	OO.importorderDialog.cancelEvent.subscribe(function(e, a, o){
		OO.get("form_importorder").reset();
	});
	sd.style.display = "block";	
	OO.importorderDialog.render();
	OO.importorderDialog.show();
}
OO.printallDialog = false;	
OO.toggle_printall = function (){
	var sd = OO.get("printall_dialog");
	if(!OO.printallDialog){	
		OO.printallDialog = new YAHOO.widget.Dialog("printall_dialog",{
			  	fixedcenter: true,
			  	draggable: false,
			  	visible : false, 
			 	modal : true,
			  	close: true
		});
		var listeners = new YAHOO.util.KeyListener(document, { keys : 27 }, {fn: function() { OO.printallDialog.cancel();} } );
		OO.printallDialog.cfg.queueProperty("keylisteners", listeners);
	}
	OO.printallDialog.cancelEvent.subscribe(function(e, a, o){
		OO.get("form_printall").reset();
	});
	sd.style.display = "block";	
	OO.printallDialog.render();
	OO.printallDialog.show();
}
OO.exportallDialog = false;	
OO.toggle_exportall = function (){
	var sd = OO.get("exportall_dialog");
	if(!OO.exportallDialog){	
		OO.exportallDialog = new YAHOO.widget.Dialog("exportall_dialog",{
			  	fixedcenter: true,
			  	draggable: false,
			  	visible : false, 
			 	modal : true,
			  	close: true
		});
		var listeners = new YAHOO.util.KeyListener(document, { keys : 27 }, {fn: function() { OO.exportallDialog.cancel();} } );
		OO.exportallDialog.cfg.queueProperty("keylisteners", listeners);
	}
	OO.exportallDialog.cancelEvent.subscribe(function(e, a, o){
		OO.get("form_exportall").reset();
	});
	sd.style.display = "block";	
	OO.exportallDialog.render();
	OO.exportallDialog.show();
}
OO.completeallDialog = false;	
OO.toggle_completeall = function (){
	var sd = OO.get("completeall_dialog");
	if(!OO.completeallDialog){	
		OO.completeallDialog = new YAHOO.widget.Dialog("completeall_dialog",{
			  	fixedcenter: true,
			  	draggable: false,
			  	visible : false, 
			 	modal : true,
			  	close: true
		});
		var listeners = new YAHOO.util.KeyListener(document, { keys : 27 }, {fn: function() { OO.completeallDialog.cancel();} } );
		OO.completeallDialog.cfg.queueProperty("keylisteners", listeners);
	}
	OO.completeallDialog.cancelEvent.subscribe(function(e, a, o){
		OO.get("form_completeall").reset();
	});
	sd.style.display = "block";	
	OO.completeallDialog.render();
	OO.completeallDialog.show();
}
</script> 
<div id="importorder_dialog" style="width: 450px; display: none;">
	<div class="hd">{$mod_strings['LBL_IMPORT_TITLE']}</div>
	<div class="bd">
	<form name="importorder" id="form_importorder" method="POST" action="index.php?module=xeBayOrders&action=importorder">
		<table class='edit view tabForm'>
			<tr>
				<td scope="row" valign="top" width="55%">
					{$mod_strings['LBL_EBAY_ACCOUNT']}
				</td>
				<td width="45%">	
					<input type="hidden" name="ebay_account_name" value="">{$ebay_account_options}
				</td>
			</tr>
			<tr>
				<td scope="row" valign="top">
					{$mod_strings['LBL_NUMBER_OF_DAYS']}
				</td>
				<td>	
					<input type="hidden" name="number_of_days" value="">
			        <select name='number_of_days' id='number_of_days' title=''>
				        <option value='1'>1</option>
				        <option value='2' selected>2</option>
				        <option value='3'>3</option>
				        <option value='5'>5</option>
				        <option value='7'>7</option>
				        <option value='15'>15</option>
				        <option value='30'>30</option>
				        <option value='90'>90</option>
			        </select>
				</td>
			</tr>
		</table>
	</form>
	<div style="text-align: right;">
		<button id="btn-save-importorderDialog" class="button" type="button" onclick="OO.get('form_importorder').submit()">{$mod_strings['LBL_APPLY_BUTTON']}</button>&nbsp;
		<button id="btn-cancel-importorderDialog" class="button" type="button" onclick="OO.importorderDialog.cancel()">{$mod_strings['LBL_CANCEL_BUTTON']}</button>&nbsp;
	</div>
	</div>
</div>
<div id="printall_dialog" style="width: 450px; display: none;">
	<div class="hd">{$mod_strings['LBL_PRINTALL_TITLE']}</div>
	<div class="bd">
	<form name="printall" id="form_printall" method="POST" action="index.php?module=xeBayOrders&action=printall">
		<table class='edit view tabForm'>
			<tr>
				<td scope="row" valign="top" width="55%">
					{$mod_strings['LBL_STOCKOUT_CHECKED']}
				</td>
				<td width="45%">	
					<input type="hidden" name="stockout_checked" value="">
					<input type="checkbox" id="stockout_checked" name="stockout_checked" checked value="1" tabindex="">
				</td>
			</tr>
			<tr>
				<td scope="row" valign="top">
					{$mod_strings['LBL_AUTO_MERGE']}
				</td>
				<td>	
					<input type="hidden" name="automerge" value="">
					<input type="checkbox" id="automerge" name="automerge" checked value="1" tabindex="">
				</td>
			</tr>
			<tr>
				<td scope="row" valign="top">
					{$mod_strings['LBL_PRINTED_ORDER_INCLUDED']}
				</td>
				<td>	
					<input type="hidden" name="printed_order_included" value="">
					<input type="checkbox" id="printed_order_included" name="printed_order_included" value="1" tabindex="">
				</td>
			</tr>
		</table>
	</form>
	<div style="text-align: right;">
		<button id="btn-save-printallDialog" class="button" type="button" onclick="OO.get('form_printall').submit()">{$mod_strings['LBL_APPLY_BUTTON']}</button>&nbsp;
		<button id="btn-cancel-printallDialog" class="button" type="button" onclick="OO.printallDialog.cancel()">{$mod_strings['LBL_CANCEL_BUTTON']}</button>&nbsp;
	</div>
	</div>
</div>
<div id="exportall_dialog" style="width: 450px; display: none;">
	<div class="hd">{$mod_strings['LBL_EXPORTALL_TITLE']}</div>
	<div class="bd">
	<form name="exportall" id="form_exportall" method="POST" action="index.php?module=xeBayOrders&action=exportall">
		<table class='edit view tabForm'>
			<tr>
				<td scope="row" valign="top" width="55%">
					{$mod_strings['LBL_STOCKOUT_CHECKED']}
				</td>
				<td width="45%">	
					<input type="hidden" name="stockout_checked" value="">
					<input type="checkbox" id="stockout_checked" name="stockout_checked" checked value="1" tabindex="">
				</td>
			</tr>
			<tr>
				<td scope="row" valign="top">
					{$mod_strings['LBL_AUTO_MERGE']}
				</td>
				<td>	
					<input type="hidden" name="automerge" value="">
					<input type="checkbox" id="automerge" name="automerge" checked value="1" tabindex="">
				</td>
			</tr>
			<tr>
				<td scope="row" valign="top">
					{$mod_strings['LBL_PRINTED_ORDER_INCLUDED']}
				</td>
				<td>	
					<input type="hidden" name="printed_order_included" value="">
					<input type="checkbox" id="printed_order_included" name="printed_order_included" value="1" tabindex="">
				</td>
			</tr>
			<tr>
				<td scope="row" valign="top">
					{$mod_strings['LBL_EXPRESS_CARRIER']}
				</td>
				<td>	
					<input type='hidden' name='express_carrier' value='0'>
					<select name='express_carrier'>{$express_carrier_options}</select>
				</td>
			</tr>
		</table>
	</form>
	<div style="text-align: right;">
		<button id="btn-save-exportallDialog" class="button" type="button" onclick="OO.get('form_exportall').submit()">{$mod_strings['LBL_APPLY_BUTTON']}</button>&nbsp;
		<button id="btn-cancel-exportallDialog" class="button" type="button" onclick="OO.exportallDialog.cancel()">{$mod_strings['LBL_CANCEL_BUTTON']}</button>&nbsp;
	</div>
	</div>
</div>
<div id="completeall_dialog" style="width: 450px; display: none;">
	<div class="hd">{$mod_strings['LBL_COMPLETEALL_TITLE']}</div>
	<div class="bd">
	<form name="completeall" id="form_completeall" method="POST" action="index.php?module=xeBayOrders&action=completeall">
		<table class='edit view tabForm'>
				<tr>
					<td scope="row" valign="top" width="55%">
						{$mod_strings['LBL_UNPRINTED_ORDER_INCLUDED']}
					</td>
					<td width="45%">	
						<input type="hidden" name="unprinted_order_included" value="">
						<input type="checkbox" id="unprinted_order_included" name="unprinted_order_included" value="1" tabindex="">
					</td>
				</tr>
		</table>
	</form>
	<div style="text-align: right;">
		<button id="btn-save-completeallDialog" class="button" type="button" onclick="OO.get('form_completeall').submit()">{$mod_strings['LBL_APPLY_BUTTON']}</button>&nbsp;
		<button id="btn-cancel-completeallDialog" class="button" type="button" onclick="OO.completeallDialog.cancel()">{$mod_strings['LBL_CANCEL_BUTTON']}</button>&nbsp;
	</div>
	</div>
</div>
&nbsp;&nbsp;
<input title="{$mod_strings['LBL_IMPORT_TIPS']}"  class="button" type="submit" name="button" value="{$mod_strings['LBL_IMPORT']}" id="import_order" onclick="OO.toggle_importorder()">
&nbsp;&nbsp;
<input title="{$mod_strings['LBL_PRINT_TIPS']}"  class="button" type="submit" name="button" value="{$mod_strings['LBL_PRINT_ALL']}" id="print_all" onclick="OO.toggle_printall()">
&nbsp;&nbsp;
<input title="{$mod_strings['LBL_EXPORT_TIPS']}"  class="button" type="submit" name="button" value="{$mod_strings['LBL_EXPORT_ALL']}" id="export_all" onclick="OO.toggle_exportall()">
&nbsp;&nbsp;
<input title="{$mod_strings['LBL_COMPLERE_ALL_TIPS']}"  class="button" type="submit" name="button" value="{$mod_strings['LBL_COMPLERE_ALL']}" id="complete_all" onclick="OO.toggle_completeall()">
<br/>
<br/>
EOF;

		$shortcuts_handled = <<<EOF
<script>
function automessage()
{
   var href="index.php?module=xeBayOrders&action=automessage&eturn_module=xeBayOrders&return_action=index";
   window.location.href=href;
}
</script> 
<input title="{$mod_strings['LBL_AUTO_MESSAGE_TIPS']}"  class="button" type="submit" name="button" value="{$mod_strings['LBL_AUTO_MESSAGE']}" id="auto_message" onclick="return automessage()">
<br/>
<br/>
EOF;
		switch ($this->filter) {
		case 'unhandled':
			echo $shortcuts_unhandled;
			break;
		case 'handled':
			echo $shortcuts_handled;
			break;
		default:
			break;
		}

 		parent::display();
	}
}
