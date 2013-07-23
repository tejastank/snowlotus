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

class xeBayUser extends Basic {
	var $new_schema = true;
	var $module_dir = 'xeBayUsers';
	var $object_name = 'xeBayUser';
	var $table_name = 'xebayusers';
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

	var $aboutmeurl;
	var $feedbackscore;
	var $registrationdate;
	var $selleritemsurl;
	var $sellerlevel;
	var $site;
	var $storename;
	var $storeurl;

	var $xebaysellersurveys;

	function xeBayUser()
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
        global $mod_strings;
        $id = $this->id;
        $sync_icon = "<img alt='' border='0' src='".SugarThemeRegistry::current()->getImageURL('Inventory_in.png')."'>";
        $sync = "<a href='index.php?module=xeBayUsers&action=sync&xebayuser_id={$id}&return_module=xeBayUsers&return_action=index' title='{$mod_strings['LBL_SYNC']}'>{$sync_icon}</a>";

		$field_list = $this->get_list_view_array();

        $field_list['SYNC_USER_DATA'] = $sync;

		return $field_list;
	}

	function mark_deleted($id)
	{
		$GLOBALS['db']->query("DELETE FROM xebaysellersurveys WHERE xebaysellersurveys.xebayuser_id ='{$this->id}'");
		parent::mark_deleted($id);
	}

	function get_sale_status()
	{
		$sale_status = array();

		// set_time_limit(60 * 3);
		// $this->load_relationship('xebaysellersurveys');
		// $listings = $this->xebaysellersurveys->getBeans();

		$bean = BeanFactory::getBean('xeBaySellerSurveys');
		$where = "xebayuser_id='{$this->id}'";
		$resp = $bean->get_list("", $where, 0, -99, -99, 0, false, array('quantitysold_permonth', 'convertedstartprice'));
		$listings = $resp['list'];

		$monthly_sales = 0;
		$monthly_sales_amount = 0;
		$not_selling = 0;
		foreach ($listings as &$listing) {
			if ($listing->quantitysold_permonth > 0) {
				$monthly_sales_amount += $listing->quantitysold_permonth * $listing->convertedstartprice;
				$monthly_sales += $listing->quantitysold_permonth;
			} else {
				$not_selling++;
			}
		}

		$sale_status['monthly_sales'] = $monthly_sales;
		$sale_status['monthly_sales_amount'] = "USD {$monthly_sales_amount}";
		$listings_count = count($listings);
		$sale_status['not_selling_rate'] = "{$not_selling} / {$listings_count}";

		return $sale_status;
	}
}
?>
