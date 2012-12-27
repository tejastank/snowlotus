<?PHP
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

class xeBayAccount extends Basic {
	var $new_schema = true;
	var $module_dir = 'xeBayAccounts';
	var $object_name = 'xeBayAccount';
	var $table_name = 'xebayaccounts';
	var $importable = true;
	var $disable_row_level_security = true ; // to ensure that modules created and deployed under CE will continue to function under team security if the instance is upgraded to PRO
	var $id;
	var $name;
	var $date_entered;
	var $date_modified;
	var $modified_user_id;
	var $modified_by_name;
	var $created_by;
	var $created_by_name;
	var $description;
	var $deleted;
	var $created_by_link;
	var $modified_user_link;
	var $assigned_user_id;
	var $assigned_user_name;
	var $assigned_user_link;

	var $ebay_auth_token;
	var $hard_expiration_time;
	var $session_id;

	var $additional_column_fields = Array('session_id');

	function xeBayAccount()
	{
		parent::Basic();
	}
	
	function bean_implements($interface)
	{
		switch ($interface) {
			case 'ACL': return true;
		}
		return false;
	}

	function fill_in_additional_detail_fields()
	{
		if (!empty($_REQUEST['name']))
			$this->name = $_REQUEST['name'];

		if (!empty($_REQUEST['session_id']))
			$this->session_id = $_REQUEST['session_id'];

		parent::fill_in_additional_detail_fields();
	}

	function get_accounts($name)
	{
		$accounts = array();

		if ($name == 'All') {
			$resp = $this->get_list("", "ebay_auth_token<>''", 0, -1, -1, 0, false, array('id', 'ebay_auth_token'));
		} else {
			$resp = $this->get_list("", "name='$name'", 0, -1, -1, 0, false, array('id', 'ebay_auth_token'));
		}

		if ($resp['row_count'] > 0) {
			foreach ($resp['list'] as &$account) {
				$accounts[$account->id] = $account->ebay_auth_token;
			}
		}

		return $accounts;
	}
}
?>
