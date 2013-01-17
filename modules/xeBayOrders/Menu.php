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


global $mod_strings, $app_strings, $sugar_config;

$result = $GLOBALS['db']->query("SELECT count(*) c FROM xeBayOrders WHERE handled_status = 'unhandled' AND deleted = 0");
$assoc = $GLOBALS['db']->fetchByAssoc($result);
$lbl_list_unhandled = $mod_strings['LNK_LIST_UNHANDLED'] . '(<span style="color:red">' . $assoc['c'] . '</span>)';

$result = $GLOBALS['db']->query("SELECT count(*) c FROM xeBayOrders WHERE handled_status = 'handled' AND deleted = 0");
$assoc = $GLOBALS['db']->fetchByAssoc($result);
$lbl_list_handled = $mod_strings['LNK_LIST_HANDLED'] . '(<span style="color:red">' . $assoc['c'] . '</span>)';

$result = $GLOBALS['db']->query("SELECT count(*) c FROM xeBayOrders WHERE handled_status = 'suspended' AND deleted = 0");
$assoc = $GLOBALS['db']->fetchByAssoc($result);
$lbl_list_suspended = $mod_strings['LNK_LIST_SUSPENDED'] . '(<span style="color:red">' . $assoc['c'] . '</span>)';

$result = $GLOBALS['db']->query("SELECT count(*) c FROM xeBayOrders WHERE handled_status = 'deleted' AND deleted = 0");
$assoc = $GLOBALS['db']->fetchByAssoc($result);
$lbl_list_deleted = $mod_strings['LNK_LIST_DELETED'] . '(<span style="color:red">' . $assoc['c'] . '</span>)';

switch ($_REQUEST['filter']) {
case 'handled':
	$lbl_list_handled = "<b>$lbl_list_handled</b>";
	break;
case 'suspended':
	$lbl_list_suspended = "<b>$lbl_list_suspended</b>";
	break;
case 'deleted':
	$lbl_list_deleted = "<b>$lbl_list_deleted</b>";
	break;
case 'unhandled':
default:
	$lbl_list_unhandled = "<b>$lbl_list_unhandled</b>";
	break;
	break;
}
 
// if(ACLController::checkAccess('xeBayOrders', 'list', true))$module_menu[]=Array("index.php?module=xeBayOrders&action=index&return_module=xeBayOrders&return_action=DetailView", $mod_strings['LNK_LIST'],"eBayOrders", 'xeBayOrders');
if(ACLController::checkAccess('xeBayOrders', 'listUnhandled', true))$module_menu[]=Array("index.php?module=xeBayOrders&action=index&filter=unhandled&return_module=xeBayOrders&return_action=DetailView", $lbl_list_unhandled,"eBayOrders", 'xeBayOrders');
if(ACLController::checkAccess('xeBayOrders', 'listHandled', true))$module_menu[]=Array("index.php?module=xeBayOrders&action=index&filter=handled&return_module=xeBayOrders&return_action=DetailView", $lbl_list_handled,"eBayOrders", 'xeBayOrders');
if(ACLController::checkAccess('xeBayOrders', 'listSuspended', true))$module_menu[]=Array("index.php?module=xeBayOrders&action=index&filter=suspended&return_module=xeBayOrders&return_action=DetailView", $lbl_list_suspended,"eBayOrders", 'xeBayOrders');
if(ACLController::checkAccess('xeBayOrders', 'listDeleted', true))$module_menu[]=Array("index.php?module=xeBayOrders&action=index&filter=deleted&return_module=xeBayOrders&return_action=DetailView", $lbl_list_deleted,"eBayOrders", 'xeBayOrders');
if(ACLController::checkAccess('xeBayOrders', 'edit', true))$module_menu[]=Array("index.php?module=xeBayOrders&action=EditView&return_module=xeBayOrders&return_action=DetailView", $mod_strings['LNK_NEW_RECORD'],"CreateeBayOrders", 'xeBayOrders');
//if(ACLController::checkAccess('xeBayOrders', 'import', true))$module_menu[]=Array("index.php?module=Import&action=Step1&import_module=xeBayOrders&return_module=xeBayOrders&return_action=index", $app_strings['LBL_IMPORT'],"Import", 'xeBayOrders');
// if(ACLController::checkAccess('xeBayOrders', 'test', true))$module_menu[]=Array("index.php?module=xeBayOrders&action=Test&return_module=xeBayOrders&return_action=index", 'test',"Test", 'xeBayOrders');
