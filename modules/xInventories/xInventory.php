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

class xInventory extends Basic {
	var $new_schema = true;
	var $module_dir = 'xInventories';
	var $object_name = 'xInventory';
	var $table_name = 'xinventories';
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

	var $strategy;
	var $subtitle;
	var $xcategory_id;
	var $xcategory_name;
	var $category_link;
	var $price;
	var $width;
	var $height;
	var $deep;
	var $weight;
	var $quantity;
	var $inventory_cap;
	var $inventory_floor;
	var $goods_allocation;
	var $body_html;
	var $xinventoryrecords;

	function xInventory()
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

    function get_management_html()
    {
        global $mod_strings;

        $id = $this->id;
        $in_icon = "<img alt='' border='0' src='".SugarThemeRegistry::current()->getImageURL('Inventory_in.png')."'>";
        $out_icon = "<img alt='' border='0' src='".SugarThemeRegistry::current()->getImageURL('Inventory_out.png')."'>";
        $management = "<a href='index.php?module=xInventoryRecords&action=EditView&return_module=xInventories&return_action=index&xinventory_req=true&xinventory_id={$id}&operation=in' title='{$mod_strings['LBL_INVENTORY_IN']}'>{$in_icon}</a>";
        $management .= "&nbsp;&nbsp;";
        $management .= "<a href='index.php?module=xInventoryRecords&action=EditView&return_module=xInventories&return_action=index&xinventory_req=true&xinventory_id={$id}&operation=out' title='{$mod_strings['LBL_INVENTORY_OUT']}'>{$out_icon}</a>";
        return $management;
    }

	function get_list_view_data()
	{
		$field_list = $this->get_list_view_array();

        $field_list['INVENTORY_MANAGEMENT'] = $this->get_management_html();

		return $field_list;
	}

	function get_body_html()
	{
		return $this->body_html;
	}

	function get_subtitle()
	{
		return $this->subtitle;
	}
}
?>
