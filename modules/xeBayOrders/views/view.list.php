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
	function listViewPrepare()
	{
		if (!empty($_REQUEST['filter']) && $_REQUEST['filter'] != 'deleted')
			$this->where = "handled_status='{$_REQUEST['filter']}'";
		else
			$this->where = "handled_status='unhandled'";
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

 	public function preDisplay()
 	{
		// echo "<pre>";
		// print_r($_REQUEST);
		// print_r($this->params);
		// print_r($this->where);
		// echo "</pre>";
 		parent::preDisplay();

		$this->showMassupdateFields = false;

		$items = array();

		if (empty($_REQUEST['filter']) || (!empty($_REQUEST['filter']) && $_REQUEST['filter'] == 'unhandled')) {
			$items[] = $this->buildLinks('LBL_SHIPPING_MARK_CONFIRMATION', 'shippingMark', 'LBL_SHIPPING_MARK');
			$items[] = $this->buildLinks('LBL_PRINT_CONFIRMATION', 'print', 'LBL_PRINT');
			$items[] = $this->buildLinks('LBL_SUSPEND_CONFIRMATION', 'suspend', 'LBL_SUSPEND');
		}

		if (!empty($_REQUEST['filter']) && $_REQUEST['filter'] == 'handled') {
			$items[] = $this->buildLinks('LBL_REDELIVER_CONFIRMATION', 'redeliver', 'LBL_REDELIVER');
			$items[] = $this->buildLinks('LBL_UNHANDLED_MARK_CONFIRMATION', 'unhandledMark', 'LBL_MARK_AS_UNHANDLED');
		}

		if (!empty($_REQUEST['filter']) && $_REQUEST['filter'] == 'suspended') {
			$items[] = $this->buildLinks('LBL_RESUME_CONFIRMATION', 'resume', 'LBL_RESUME');
		}

		$this->lv->actionsMenuExtraItems = $items;
 	}
}
