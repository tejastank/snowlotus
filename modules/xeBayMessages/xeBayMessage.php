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

class xeBayMessage extends Basic {
	var $new_schema = true;
	var $module_dir = 'xeBayMessages';
	var $object_name = 'xeBayMessage';
	var $table_name = 'xebaymessages';
	var $importable = true;
	var $disable_row_level_security = true ; // to ensure that modules created and deployed under CE will continue to function under team security if the instance is upgraded to PRO
	var $id;
	var $date_entered;
	var $date_modified;
	var $modified_user_id;
	var $modified_by_name;
	var $created_by;
	var $created_by_name;
	var $deleted;
	var $created_by_link;
	var $modified_user_link;
	var $assigned_user_id;
	var $assigned_user_name;
	var $assigned_user_link;
	
	// Item
	var $item_id;
	var $currency_id;
	var $price;
	var $endtime;
	var $view_item_url;
	var $title;

	var $creation_date;
	var $message_status;

	// Question
	var $name;
	var $description;
	var $message_id;
	var $message_type;
	var $question_type;
	var $recipient_id;
	var $sender_email;
	var $sender_id;

	var $responses;

	var $flagged;
	var $read_status;
	var $replied;
	
	var $date_sent;

	function xeBayMessage()
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

	function get_list_view_data()
	{
		$field_list = $this->get_list_view_array();

		if ($field_list['READ_STATUS'] != true) {
			$subject = "<b>{$field_list['NAME']}</b>";
		} else {
			$subject = $field_list['NAME'];
		}
		$subjectUrl = "<a href='index.php?module=xeBayMessages&action=DetailView&return_module=xeBayMessages&return_action=index&record={$field_list['ID']}' title=''>{$subject}</a>";
		$field_list['SUBJECT_CUSTOM'] = $subjectUrl;

		return $field_list;
	}

	function get_salutation()
	{
		return "Hi {$this->sender_id},";
	}

	function get_template()
	{
		return "";
	}

	function get_signature()
	{
		return "Your sincerely.\n- {$this->xebayaccount_name}";
	}

	function read_status_update($id, $status)
	{
		global $current_user;
		$date_modified = $GLOBALS['timedate']->nowDb();
        if ( isset($this->field_defs['modified_user_id']) ) {
            if (!empty($current_user)) {
                $this->modified_user_id = $current_user->id;
            } else {
                $this->modified_user_id = 1;
            }
            $query = "UPDATE $this->table_name set read_status='{$status}' , date_modified = '$date_modified', modified_user_id = '$this->modified_user_id' where id='$id'";
        } else {
            $query = "UPDATE $this->table_name set read_status='{$status}' , date_modified = '$date_modified' where id='$id'";
        }
        $this->db->query($query, true,"Error update record read status: ");
	}

	function replied_status_update($id, $status)
	{
		global $current_user;
		$date_modified = $GLOBALS['timedate']->nowDb();
        if ( isset($this->field_defs['modified_user_id']) ) {
            if (!empty($current_user)) {
                $this->modified_user_id = $current_user->id;
            } else {
                $this->modified_user_id = 1;
            }
            $query = "UPDATE $this->table_name set replied='{$status}' , date_modified = '$date_modified', modified_user_id = '$this->modified_user_id' where id='$id'";
        } else {
            $query = "UPDATE $this->table_name set replied='{$status}' , date_modified = '$date_modified' where id='$id'";
        }
        $this->db->query($query, true,"Error update record replied status: ");
	}
}
?>
