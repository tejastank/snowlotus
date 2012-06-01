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

class xeBayMessagesViewList extends ViewList
{
	function xeBayMessagesViewList()
	{
        parent:: ViewList();
    }

	function listViewPrepare()
	{
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

		$shortcuts = <<<EOF
<script>
var OO = {};
OO.get = YAHOO.util.Dom.get;
OO.checkDialog = false;	
OO.toggle_check = function (){
	var sd = OO.get("check_dialog");
	if(!OO.checkDialog){	
		OO.checkDialog = new YAHOO.widget.Dialog("check_dialog",{
			  	fixedcenter: true,
			  	draggable: false,
			  	visible : false, 
			 	modal : true,
			  	close: true
		});
		var listeners = new YAHOO.util.KeyListener(document, { keys : 27 }, {fn: function() { OO.checkDialog.cancel();} } );
		OO.checkDialog.cfg.queueProperty("keylisteners", listeners);
	}
	OO.checkDialog.cancelEvent.subscribe(function(e, a, o){
		OO.get("form_check").reset();
	});
	sd.style.display = "block";	
	OO.checkDialog.render();
	OO.checkDialog.show();
}
</script> 
<div id="check_dialog" style="width: 450px; display: none;">
	<div class="hd">{$mod_strings['LBL_CHECK_TITLE']}</div>
	<div class="bd">
	<form name="check" id="form_check" method="POST" action="index.php?module=xeBayMessages&action=check">
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
			<tr>
				<td scope="row" valign="top">
					{$mod_strings['LBL_MESSAGE_STATUS']}
				</td>
				<td>	
					<input type="hidden" name="message_status" value="">
			        <select name='message_status' id='message_status' title=''>
				        <option value=''></option>
				        <option value='Unanswered'>{$mod_strings['LBL_UNANSWERED']}</option>
				        <option value='Answered'>{$mod_strings['LBL_ANSWERED']}</option>
			        </select>
				</td>
			</tr>
		</table>
	</form>
	<div style="text-align: right;">
		<button id="btn-save-checkDialog" class="button" type="button" onclick="OO.get('form_check').submit()">{$mod_strings['LBL_APPLY_BUTTON']}</button>&nbsp;
		<button id="btn-cancel-checkDialog" class="button" type="button" onclick="OO.checkDialog.cancel()">{$mod_strings['LBL_CANCEL_BUTTON']}</button>&nbsp;
	</div>
	</div>
</div>
&nbsp;&nbsp;
<input title="{$mod_strings['LBL_CHECK_TIPS']}"  class="button" type="submit" name="button" value="{$mod_strings['LBL_CHECK']}" id="check_btn" onclick="OO.toggle_check()">
<br/>
<br/>
EOF;

        echo $shortcuts;
 		parent::display();
	}
}
