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
		if ($this->filter != 'deleted')
			$this->where = "handled_status='{$this->filter}'";

		parent::listViewPrepare();
	}

	function listViewProcess()
 	{
		parent::listViewProcess();
	}

	public function buildLinks($confirmation, $entryPoint, $label)
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
		global $mod_strings;
		// echo "<pre>";
		// print_r($_REQUEST);
		// print_r($this->params);
		// print_r($this->where);
		// echo "</pre>";

		$shortcuts_unhandled = <<<EOF
<script>
function automerge()
{
   var href="index.php?module=xeBayOrders&action=automerge&eturn_module=xeBayOrders&return_action=index";
   window.location.href=href;
}
function completeall()
{
   var href="index.php?module=xeBayOrders&action=completeall&eturn_module=xeBayOrders&return_action=index";
   window.location.href=href;
}
function printall()
{
   var href="index.php?module=xeBayOrders&action=printall&eturn_module=xeBayOrders&return_action=index";
   window.location.href=href;
}
function sfcexport()
{
   var href="index.php?entryPoint=sfcFormatExport&module=xeBayOrders&action=index";
   window.location.href=href;
}
function pfcexport()
{
   var href="index.php?entryPoint=pfcFormatExport&module=xeBayOrders&action=index";
   window.location.href=href;
}
</script> 
<input title="{$mod_strings['LBL_AUTO_MERGE']}"  class="button" type="submit" name="button" value="{$mod_strings['LBL_AUTO_MERGE']}" id="auto_merge" onclick="return automerge()">
&nbsp;&nbsp;
<input title="{$mod_strings['LBL_COMPLERE_ALL_TIPS']}"  class="button" type="submit" name="button" value="{$mod_strings['LBL_COMPLERE_ALL']}" id="complete_all" onclick="return completeall()">
&nbsp;&nbsp;
<input title="{$mod_strings['LBL_PRINT_TIPS']}"  class="button" type="submit" name="button" value="{$mod_strings['LBL_PRINT_ALL']}" id="print_all" onclick="return printall()">
&nbsp;&nbsp;
<input title="{$mod_strings['LBL_SFC_EXPORT']}"  class="button" type="submit" name="button" value="{$mod_strings['LBL_SFC_EXPORT']}" id="sfc_export" onclick="return sfcexport()">
&nbsp;&nbsp;
<input title="{$mod_strings['LBL_PFC_EXPORT']}"  class="button" type="submit" name="button" value="{$mod_strings['LBL_PFC_EXPORT']}" id="pfc_export" onclick="return pfcexport()">
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
