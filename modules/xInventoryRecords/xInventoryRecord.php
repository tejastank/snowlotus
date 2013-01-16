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

    var $xinventory_id;
	var $xinventory_name;
	var $xinventory_link;
    var $operation;
	var $stock_taking;
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

	function get_list_view_data()
	{
        global $mod_strings;

		$field_list = $this->get_list_view_array();

		$operation = $field_list['OPERATION'];
		$operation_icon = "";
		if ($operation  == 'in')
        	$operation_icon = "<img style='margin-left:6px;' alt='' border='0' src='".SugarThemeRegistry::current()->getImageURL('Inventory_in.png')."'>";
		else
        	$operation_icon = "<img style='margin-left:6px;' alt='' border='0' src='".SugarThemeRegistry::current()->getImageURL('Inventory_out.png')."'>";
        $field_list['OPERATION'] = $operation_icon;

		return $field_list;
	}

    function fill_in_additional_detail_fields()
    {
        parent::fill_in_additional_detail_fields();
        if (!empty($_REQUEST['xinventory_req'])) {
            if (!empty($_REQUEST['operation']))
                $this->operation = $_REQUEST['operation'];

            if (!empty($_REQUEST['xinventory_id'])) {
                $this->xinventory_id = $_REQUEST['xinventory_id'];
                $bean = BeanFactory::getBean('xInventories');
                if ($bean->retrieve($this->xinventory_id)) {
                    $this->xinventory_name = $bean->name;
                    $this->name = $this->xinventory_name;
                }
            }
        }
    }

    function save($check_notify = FALSE)
    {
        $item = BeanFactory::getBean('xInventories');

		if ($this->new_with_id == true) {
            if ($item->retrieve($this->xinventory_id) != null) {
				switch ($this->operation) {
				case 'in':
                    $item->quantity += $this->quantity;
					break;
				case 'out':
                    $quantity = $item->quantity;
                    $quantity -= $this->quantity;
                    if ($quantity < 0) {
                        $this->quantity = $item->quantity;
                        $item->quantity = 0;
                    } else {
                        $item->quantity = $quantity;
                    }
					break;
				default:
					echo "inventory record operation error!!!";
					exit;
					break;
				}
                $item->save();
            }
        }

        parent::save($check_notify);
    }

	function mark_deleted($id)
    {
        $item = BeanFactory::getBean('xInventories');

        if ($item->retrieve($this->xinventory_id) != null) {
            if ($this->operation == 'in') {
                $item->quantity -= $this->quantity;
                if ($item->quantity < 0)
                    $item->quantity = 0;
            } else {
                $item->quantity += $this->quantity;
            }
            $item->save();
        }

        parent::mark_deleted($id);
    }
}

function getInventoryRecordOperationDropDown()
{
	global $mod_strings;

    $list = array (
		'in' => $mod_strings['LBL_INVENTORY_IN'],
		'out' => $mod_strings['LBL_INVENTORY_OUT'],
	);

	return $list;
}
?>
