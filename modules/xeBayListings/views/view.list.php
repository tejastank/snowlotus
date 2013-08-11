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

class xeBayListingsViewList extends ViewList
{
	function xeBayListingsViewList()
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
	return sListView.send_form(true, 'xeBayListings', 'index.php?entryPoint={$entryPoint}', '{$app_strings['LBL_LISTVIEW_NO_SELECTED']}');
}
return false;
EOF;
	
		$js = str_replace(array("\r","\n"),'',$js);
	
		return "<a href='javascript:void(0)' id=\"suspend_listview\" onclick=\"$js\">{$mod_strings[$label]}</a>";
	}

 	function preDisplay()
 	{
 		parent::preDisplay();
		
		$items = array();
		$items[] = $this->buildLinks('LBL_UPDATE_CONFIRMATION', 'updatesellerlists', 'LBL_UPDATE');
		$items[] = $this->buildLinks('LBL_EXPORT_FILE_EXCHANGE_FORMAT_CONFIRMATION', 'exportfileexchangeformat', 'LBL_EXPORT_FILE_EXCHANGE_FORMAT');
		$this->lv->actionsMenuExtraItems = $items;
 	}

	function display()
	{
		global $mod_strings;

		$javascript = <<<EOF
<script>
function open_popup_preview(id)
{
	if (typeof(popupCount) == "undefined" || popupCount == 0)
	   popupCount = 1;

	//globally changing width and height of standard pop up window from 600 x 400 to 800 x 800
	width = 1024;
	height = 600;

	// launch the popup
	URL = 'index.php?'
		+ 'module=xeBayListings'
		+ '&action=preview'
		+ '&record=' + id;

	windowName = 'Seller List Preview' + '_popup_window' + popupCount;
	popupCount++;

	windowFeatures = 'width=' + width
		+ ',height=' + height
		+ ',resizable=1,scrollbars=1';

	win = SUGAR.util.openWindow(URL, windowName, windowFeatures);

	if(window.focus)
	{
		// put the focus on the popup if the browser supports the focus() method
		win.focus();
	}

	win.popupCount = popupCount;

	return win;
}
</script> 
EOF;
		echo $javascript;

 		parent::display();
	}
}
