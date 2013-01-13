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

class xeBayTransaction extends Basic {
	var $new_schema = true;
	var $module_dir = 'xeBayTransactions';
	var $object_name = 'xeBayTransaction';
	var $table_name = 'xebaytransactions';
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

	var $xebayorder_id;
	var $xebayorder_name;
	var $xebayorder_link;
	var $primitive_order_id;
	var $stockout;
	var $actual_handling_cost_currency_id;
	var $actual_handling_cost_value;
	var $actual_shipping_cost_currency_id;
	var $actual_shipping_cost_value;
	var $item_item_id;
	var $item_view_item_url;
	var $item_site;
	var $xinventory_id; // sku
	var $xinventory_name;
	var $customs_declaration;
	var $width;
	var $height;
	var $deep;
	var $weight;
	var $goods_allocation;
	var $orderline_item_id;
	var $quantity_purchased;
	var $transaction_id;
	var $sales_record_number;
	var $price_currency_id;
	var $price_value;

	function xeBayTransaction()
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

		if ($field_list['SALES_RECORD_NUMBER'] != -1)
			$field_list['NAME'] = '<a target="_blank" href="' . $field_list['ITEM_VIEW_ITEM_URL'] . '">' . $field_list['NAME'] . "</a>";
		if (!empty($field_list['STOCKOUT']))
			$field_list['XINVENTORY_NAME'] = "<span style='color:red'>{$field_list['XINVENTORY_NAME']}</span>";

		return $field_list;
	}

	function stockout_status_update($id, $status)
	{
		global $current_user;
		$date_modified = $GLOBALS['timedate']->nowDb();
        if ( isset($this->field_defs['modified_user_id']) ) {
            if (!empty($current_user)) {
                $this->modified_user_id = $current_user->id;
            } else {
                $this->modified_user_id = 1;
            }
            $query = "UPDATE $this->table_name set stockout='{$status}' , date_modified = '$date_modified', modified_user_id = '$this->modified_user_id' where id='$id'";
        } else {
            $query = "UPDATE $this->table_name set stockout='{$status}' , date_modified = '$date_modified' where id='$id'";
        }
        $this->db->query($query, true,"Error updating record stockout: ");
	}

	function stockout_status()
	{
		$stockout = $this->stockout;
		if ($this->quantity < $this->quantity_purchased) {
			$this->stockout = true;
		} else {
			$this->stockout = false;
		}

		if ($stockout != $this->stockout) {
			$this->stockout_status_update($this->id, $this->stockout);
		}

		return $this->stockout;
	}

	function new_sale_record()
	{
        $record = BeanFactory::getBean('xInventoryRecords');
        // new inventory recor
        $record->name = $this->name;
        $record->xinventory_id = $this->xinventory_id;
        $record->operation = 'out';
	    $record->price = '0.00';
	    $record->quantity = $this->quantity_purchased;
        $record->parent_type = 'xeBayTransactions';
        $record->parent_id = $this->id;
        $record->id = create_guid();
        $record->new_with_id = true;
        $record->save();
	}
}
?>
