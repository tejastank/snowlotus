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

class xInventoryRecord extends Basic {
	var $new_schema = true;
	var $module_dir = 'xInventoryRecords';
	var $object_name = 'xInventoryRecord';
	var $table_name = 'xinventoryrecords';
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

    var $inventory_id;
	var $inventory_name;
	var $inventory_link;
    var $operation;
	var $price;
	var $quantity;
	var $vendor_id;
    var $parent_type;
    var $parent_id;
    var $parent_name;

	function xInventoryRecord()
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

    // function retrieve($id = -1, $encode=true,$deleted=true)
    // {
        // parent::retrieve($id, $encode,$deleted);
    // }

    function save($check_notify = FALSE)
    {
        $bean = BeanFactory::getBean('xInventories');
        if ($bean->retrieve($this->inventory_id) == null)
            return;
        if ($this->operation == 'in') {
            $bean->quantity += $this->quantity;
        } else {
            $quantity = $bean->quantity;
            $quantity -= $this->quantity;
            if ($quantity < 0) {
                $this->quantity = $bean->quantity;
                $bean->quantity = 0;
            } else {
                $bean->quantity = $quantity;
            }
        }
        $bean->save();

        parent::save($check_notify);
    }

    function fill_in_additional_detail_fields()
    {
        parent::fill_in_additional_detail_fields();
        if (!empty($_REQUEST['operation']))
            $this->operation = $_REQUEST['operation'];

        if (!empty($_REQUEST['inventory_id'])) {
            $this->inventory_id = $_REQUEST['inventory_id'];
		    $bean = BeanFactory::getBean('xInventories');
            if ($bean->retrieve($this->inventory_id))
                $this->inventory_name = $bean->name;
        }
    }
}
?>
