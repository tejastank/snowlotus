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

class xeBaySellerSurveysViewList extends ViewList
{
	function xeBaySellerSurveysViewList()
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

		$shortcuts = <<<EOF
<script>
var OO = {};
OO.get = YAHOO.util.Dom.get;
OO.importlistDialog = false;	
OO.toggle_importlist = function (){
	var sd = OO.get("importlist_dialog");
	if(!OO.importlistDialog){	
		OO.importlistDialog = new YAHOO.widget.Dialog("importlist_dialog",{
			  	fixedcenter: true,
			  	draggable: false,
			  	visible : false, 
			 	modal : true,
			  	close: true
		});
		var listeners = new YAHOO.util.KeyListener(document, { keys : 27 }, {fn: function() { OO.importlistDialog.cancel();} } );
		OO.importlistDialog.cfg.queueProperty("keylisteners", listeners);
	}
	OO.importlistDialog.cancelEvent.subscribe(function(e, a, o){
		OO.get("form_importlist").reset();
	});
	sd.style.display = "block";	
	OO.importlistDialog.render();
	OO.importlistDialog.show();
}
</script> 
<div id="importlist_dialog" style="width: 450px; display: none;">
	<div class="hd">{$mod_strings['LBL_IMPORT_TITLE']}</div>
	<div class="bd">
	<form name="importlist" id="form_importlist" method="POST" action="index.php?module=xeBaySellerSurveys&action=importlist">
		<table class='edit view tabForm'>
			<tr>
				<td scope="row" valign="top" width="25%">
					{$mod_strings['LBL_EBAY_ACCOUNT']}
				</td>
				<td width="45%">
					<input type="text" name="user_id" id="user_id" value="" />
				</td>
			</tr>
		</table>
	</form>
	<div style="text-align: right;">
		<button id="btn-save-importlistDialog" class="button" type="button" onclick="OO.get('form_importlist').submit()">{$mod_strings['LBL_APPLY_BUTTON']}</button>&nbsp;
		<button id="btn-cancel-importlistDialog" class="button" type="button" onclick="OO.importlistDialog.cancel()">{$mod_strings['LBL_CANCEL_BUTTON']}</button>&nbsp;
	</div>
	</div>
</div>
&nbsp;&nbsp;
<input title="{$mod_strings['LBL_IMPORT_TIPS']}"  class="button" type="submit" name="button" value="{$mod_strings['LBL_IMPORT']}" id="import_order" onclick="OO.toggle_importlist()">
<br/>
<br/>
EOF;
		// echo $shortcuts;
 		parent::display();
	}
}
