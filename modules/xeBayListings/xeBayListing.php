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

class xeBayListing extends Basic {
	var $new_schema = true;
	var $module_dir = 'xeBayListings';
	var $object_name = 'xeBayListing';
	var $table_name = 'xebaylistings';
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

	var $applicationdata;
	var $autopay;
	var $bestofferenabled;
	var $conditiondescription;
	var $conditionid;
	var $country;
	var $crossbordertrade;
	var $currency;
	var $description;
	var $disablebuyerrequirements;
	// DiscountPriceInfo
	var $dispatchtimemax;
	// GetItFast
	var $hitcounter;
	// InventoryTrackingMethod, only available in AddFixedPirceItem
	// ItemCompatibilityList
	// ItemSpecifics
	// ListingCheckoutRedirectPreference
	// ListingDesigner
	// ListingDetails
	var $listingduration;
	// ListingEnhancement
	var $listingtype;
	var $location;
	var $paymentmethods;
	var $paypalemailaddress;
	var $picturedetails;
	var $postalcode;
	var $primarycategoryid;
	// ProductListingDetails
	var $quantity;
	// QuantityInfo
	// QuantityRestrictionPerBuyer
	var $returnpolicy;
	var $scheduletime;
	var $secondarycategoryid;
	var $shippingdetails;
	// ShippingPackageDetails
	// ShippingTermsInDescription
	var $shiptolocations;
	var $site;
	var $startprice;
	var $storecategory2id;
	var $storecategoryid;
	var $subtitle;
	var $name;
	var $uuid;
	// Variations, Only available in AddFixedPriceItem
	var $variations;
	var $short_title;
	var $primarycategory_name;
	var $primarycategory_link;
	var $secondarycategory_name;
	var $secondarycategory_link;
	var $xinventory_id;
	var $xinventory_name;
	var $xinventory_link;

	var $xinventory_id_used = array();

	const shopwindow_stick_limit = 6;
	const shopwindow_correlation_limit = 10;
	const shopwindow_random_limit = 12;

	function xeBayListing()
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


        $preview_icon = "<img alt='' border='0' src='".SugarThemeRegistry::current()->getImageURL('Preview-icon.png')."'>";
		$preview_url = "<a href=\"javascript:open_popup_preview('{$field_list['ID']}')\">{$preview_icon}</a>";
		$field_list['PREVIEW_URL'] = $preview_url;

		return $field_list;
	}

	function get_description()
	{
		$desc = $this->name;

		$inner_html = $this->description;
		if (!empty($inner_html))
			$desc = html_entity_decode($inner_html);

		return $desc;
	}

	function preview_description()
	{
		$strips = array(
			"\t" => "",
			"\n" => "",
			"\r" => "",
			"\0" => "",
			"\x0B" => "",
		);
 
        $ss = new Sugar_Smarty();
        $ss->left_delimiter = '{{';
        $ss->right_delimiter = '}}';
		$ss->assign("TITLE", $this->name);
		// $ss->assign("GALLERY", $this->build_image_gallery());
		$ss->assign("DESCRIPTION", $this->get_description());
		$ss->assign("PACKAGE_INCLUDED", "");
		// $ss->assign("SHOPWINDOW_STICK", $this->build_shopwindow_topmost());
		// $ss->assign("SHOPWINDOW_CORRELATION", $this->build_shopwindow_correlation());
		// $ss->assign("SHOPWINDOW_RANDOM", $this->build_shopwindow_random());
        $desc = $ss->fetch("modules/xeBayListings/tpls/default.html");
		$desc = strtr($desc, $strips);
 
        unset($ss);

        return $desc;
	}

    public static function guid_to_uuid($guid)
	{
		$uuid = '';

		if(strlen($guid) == 36) {
			$uuid .= substr($guid, 0, 8);
			$uuid .= substr($guid, 9, 4);
			$uuid .= substr($guid, 14, 4);
			$uuid .= substr($guid, 19, 4);
			$uuid .= substr($guid, 24, 12);
		}

		return $uuid;
	}

    public static function uuid_to_guid($uuid)
	{
		$guid = '';

		if(strlen($uuid) == 32) {
			$guid .= substr($uuid, 0, 8);
			$guid .= '-';
			$guid .= substr($uuid, 8, 4);
			$guid .= '-';
			$guid .= substr($uuid, 12, 4);
			$guid .= '-';
			$guid .= substr($uuid, 16, 4);
			$guid .= '-';
			$guid .= substr($uuid, 20, 12);
		}

		return $guid;
	}
}
?>
