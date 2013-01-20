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


require_once('include/MVC/View/views/view.detail.php');

class xeBayMessagesViewDetail extends ViewDetail
{
	function xeBayMessagesViewDetail()
	{
 		parent::ViewDetail();
 	}

 	/**
 	 * display
 	 * Override the display method to support customization for the buttons that display
 	 * a popup and allow you to copy the account's address into the selected contacts.
 	 * The custom_code_billing and custom_code_shipping Smarty variables are found in
 	 * include/SugarFields/Fields/Address/DetailView.tpl (default).  If it's a English U.S.
 	 * locale then it'll use file include/SugarFields/Fields/Address/en_us.DetailView.tpl.
 	 */
	function display()
	{
		global $app_strings, $app_list_strings;
		global $mod_strings;

		parent::display();

		$smarty = new Sugar_Smarty();
		$smarty->assign('APP', $app_strings);
		$smarty->assign('MOD', $mod_strings);
		$smarty->assign('RECORD', $this->bean->id);

		$popup_request_data = array(
			'call_back_function' => 'set_return',
			'form_name' => 'xeBayMessageReply',
			'field_to_name_array' => array(
				'description' => 'response',
			),
		);
		$json = getJSONobj();
		$smarty->assign('ENCODED_TEMPLATES_POPUP_REQUEST_DATA', $json->encode($popup_request_data));
		$smarty->assign("TEMPLATE_SELECT", SugarThemeRegistry::current()->getImage('id-ff-select','',null,null,'.png',$mod_strings['LBL_SELECT']));
		$smarty->assign("TEMPLATE_CLEAR", SugarThemeRegistry::current()->getImage('id-ff-clear','',null,null,'.gif',$mod_strings['LBL_ID_FF_CLEAR']));

		$smarty->assign('SUBJECT', $this->bean->title);
		$smarty->assign('SALUTATION', str_replace("\n", "<br>", $this->bean->get_salutation()));
		$smarty->assign('RESPONSE', $this->bean->get_template());
		$smarty->assign('SIGNATURE', str_replace("\n", "<br>", $this->bean->get_signature()));
		$smarty->display("modules/xeBayMessages/tpls/reply.tpl");

		$this->bean->read_status_update($this->bean->id, true);
 	}
}

?>
