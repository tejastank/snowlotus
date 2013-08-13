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
	
	var $xebayaccount_id;
	var $xebayaccount_name;
	var $xebayaccount_link;
	
	var $xinventory_id;
	var $xinventory_name;
	var $xinventory_link;
	
	var $bid_count;
	var $endtime;
	var $hitcount;
	var $item_id;
	var $listing_type;
	var $view_item_url;
	var $listing_status;
	var $association;

	var $ebaylisting_id_used = array();

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
		
		switch ($field_list['LISTING_TYPE']) {
			case 'FixedPriceItem':
			case 'StoresFixedPrice':
				$field_list['LISTING_TYPE_ICON'] = SugarThemeRegistry::current()->getImage('icon_Fixedprice_16', 'align=absmiddle border=0', null, null, ".gif", $field_list['LISTING_TYPE']);
				break;
			case 'Chinese':
				$field_list['LISTING_TYPE_ICON'] = SugarThemeRegistry::current()->getImage('icon_Auction_16', 'align=absmiddle border=0', null, null, ".gif", $field_list['LISTING_TYPE']);
				break;
			default:
				$field_list['LISTING_TYPE_ICON'] = $field_list['LISTING_TYPE'];
				break;
		}

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

	function description_html()
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
		$ss->assign("ID", $this->id);
		$ss->assign("TITLE", $this->name);
		$ss->assign("DESCRIPTION", $this->get_description());
        $desc = $ss->fetch("modules/xeBayListings/tpls/default.html");
		$desc = strtr($desc, $strips);
 
        unset($ss);

        return $desc;
	}
	
	public function retrieve_seller_lists($skus = array())
	{
		require_once('eBayApi/GetSellerList.php');
		
		if (empty($skus)) {
			$bean = BeanFactory::getBean('xeBayAccounts');
			$endTimeFrom = date("c", time() - 30 * 24 * 60 * 60);
			$endTimeTo = date("c", time() + 45 * 24 * 60 * 60);
			$accounts = $bean->get_accounts();
			$sellerList = new GetSellerList();
			foreach ($accounts as $id => $authToken) {
				$result = $sellerList->getListing(array(
						'EndTimeFrom' => $endTimeFrom,
						'EndTimeTo' => $endTimeTo,
						'AccountID' => $id,
						'AuthToken' => $authToken,
				));
			}
		}
	}
	
	public function get_seller_lists()
	{
		$this->retrieve_seller_lists();
	}
	
	function association_update($status)
	{
		global $current_user;
		$date_modified = $GLOBALS['timedate']->nowDb();
		if ( isset($this->field_defs['modified_user_id']) ) {
			if (!empty($current_user)) {
				$this->modified_user_id = $current_user->id;
			} else {
				$this->modified_user_id = 1;
			}
			$query = "UPDATE $this->table_name set association='{$status}' , date_modified = '$date_modified', modified_user_id = '$this->modified_user_id' where id='$this->id'";
		} else {
			$query = "UPDATE $this->table_name set association='{$status}' , date_modified = '$date_modified' where id='$this->id'";
		}
		$this->db->query($query, true,"Error update association: ");
	}
	
	function revise()
	{
		require_once 'eBayApi/ReviseFixedPriceItem.php';
		require_once 'eBayApi/ReviseItem.php';
		
		$ebayAccount = BeanFactory::getBean('xeBayAccounts');
		$accounts = $ebayAccount->get_accounts('All');
		$scope = array('description', 'sku');
	
		$authToken = $accounts[$this->xebayaccount_id];
		if ($this->listing_type != 'Chinese') {
			if ($this->bid_count > 0)
				return;
			$ri = new ReviseItem();
			$ri->ryi(array(
					'ItemID' => $this->item_id,
					'Description' => $this->description_html(),
					'ApplicationData' => xeBayListing::guid_to_uuid($this->id),
					'SKU' => $this->id,
					'scope'=> $scope,
					'AuthToken' => $authToken,
			));
		} else {
			$rfpi = new ReviseFixedPriceItem();
			$rfpi->ryi(array(
					'ItemID' => $this->item_id,
					'Description' => $this->description_html(),
					'ApplicationData' => xeBayListing::guid_to_uuid($this->id),
					'SKU' => $this->id,
					'scope'=> $scope,
					'AuthToken' => $authToken,
			));
		}
		
		$this->association_update(true);
		
		return true;
	}
	
	function get_valid_listing($inventory_id)
	{
		$bean = BeanFactory::getBean('xeBayListings');
	
		$fields = array(
				'xinventory_id' => $inventory_id,
				'listing_type' => 'FixedPriceItem',
				'listing_status' => 'Active',
		);
	
		$listing = $bean->retrieve_by_string_fields($fields);
		
		if ($listing !== NULL) {
			if (in_array($listing->id, $this->ebaylisting_id_used)) {
				return null;
			}
			$this->ebaylisting_id_used[] = $listing->id;
		}

		return $listing;
	}
	
	function get_valid_listing_gallery($id /* inventory id */)
	{
		$listing = $this->get_valid_listing($id);
		if ($listing !== null) {
			return array (
					'itemID' => $listing->item_id,
					'title' => empty($listing->short_title) ? $listing->name : $listing->short_title,
					'listingType' => $listing->listing_type,
					'currencyID' => $listing->currency,
					'price' => $listing->startprice,
					'viewItemUrl' => $listing->view_item_url,
			);
		}
		return false;
	}
	
	function get_shop_window_items_random($max)
	{
		if ($max < 1)
			return array();
	
		$shop_window_items = array();
		$count = 0;
	
		$listingBean = BeanFactory::getBean('xeBayListings');
		$where = "listing_type='FixedPriceItem' AND listing_status='Active' AND item_id<>'$this->item_id'";
		$listings = $listingBean->get_list("", $where, 0, -99, -99, 0, false, array('id', 'item_id', 'name', 'short_title', 'listing_type', 'currency', 'startprice', 'view_item_url'));
		shuffle($listings['list']);
	
		foreach ($listings['list'] as &$listing) {
			if (($listing !== false) && !in_array($listing->id, $this->ebaylisting_id_used)) {
				$this->ebaylisting_id_used[] = $listing->id;
				$shop_window_items[] = array(
						'itemID' => $listing->item_id,
						'title' => empty($listing->short_title) ? $listing->name : $listing->short_title,
						'listingType' => $listing->listing_type,
						'currencyID' => $listing->currency,
						'price' => $listing->startprice,
						'viewItemUrl' => $listing->view_item_url,
				);
	
				$count++;
	
				if ($count == $max)
					break;
			}
		}
	
		return $shop_window_items;
	}
	
	function build_shopwindow_html($items, $row, $column, $rss)
	{
		$count = count($items);
	
		if ($count == 0)
			return "";
	
		if ($rss) {
			$oXMLout = new XMLWriter();
			$oXMLout->openMemory();
			$oXMLout->startDocument();
			$oXMLout->startElement("rss");
			$oXMLout->writeAttribute("version", "2.0");
			$oXMLout->startElement("channel");
			$oXMLout->writeElement("title", "Shop Window");
			$oXMLout->writeElement("link", "http://stores.ebay.com/xlongfeng");
			$oXMLout->writeElement("description", "http://stores.ebay.com/xlongfeng");
			foreach ($items as &$item) {
				$oXMLout->startElement("item");
				$oXMLout->writeElement("title", $item['title']);
				$oXMLout->writeElement("link", $item['viewItemUrl']);
				$oXMLout->writeElement("description", "http://stores.ebay.com/xlongfeng");
				$oXMLout->writeElement("itemID", $item['itemID']);
				$oXMLout->writeElement("currency", $item['currencyID']);
				$oXMLout->writeElement("price", $item['price']);
				$oXMLout->endElement();
			}
			$oXMLout->endElement();
			$oXMLout->endElement();
			$oXMLout->endDocument();
			return $oXMLout->outputMemory();
		}
	
		$html = CHtml::openTag("table", array('class'=>'shopwindow'));
	
		for ($i = 0; $i < $row; $i++) {
			$html .= CHtml::openTag("tr");
			for ($j = 0; $j < $column; $j++) {
				$html .= CHtml::openTag("td", array('class'=>'item'));
				$item = $items[$i * $column + $j];
				if (empty($item))
					break 2;
				$itemId = $item['itemID'];
				$linkBody = CHtml::openTag("ul");
	
				$linkBody .= CHtml::openTag("li", array('class'=>'item-image'));
				$linkBody .= CHtml::image("http://thumbs3.ebaystatic.com/pict/$itemId"."8080.jpg");
				$linkBody .= CHtml::closeTag("li");
	
				$linkBody .= CHtml::openTag("li", array('class'=>'item-title'));
				$linkBody .= CHtml::encode($item['title']);
				$linkBody .= CHtml::closeTag("li");
	
				$linkBody .= CHtml::openTag("li");
				{
					$linkBody .= CHtml::openTag("ul", array('class'=>'item-price'));
					$linkBody .= CHtml::openTag("li");
					if ($item['listingType'] != 'FixedPriceItem')
						$linkBody .= CHtml::image('http://q.ebaystatic.com/aw/pics/icon/iconAuction_16x16.gif');
					else
						$linkBody .= CHtml::image('http://q.ebaystatic.com/aw/pics/bin_15x54.gif');
					$linkBody .= CHtml::closeTag("li");
					$linkBody .= CHtml::openTag("li");
					$linkBody .= CHtml::encode($item['currencyID']);
					$linkBody .= CHtml::closeTag("li");
					$linkBody .= CHtml::openTag("li");
					$linkBody .= CHtml::encode($item['price']);
					$linkBody .= CHtml::closeTag("li");
					$linkBody .= CHtml::closeTag("ul");
				}
				$linkBody .= CHtml::closeTag("li");
	
				$linkBody .= CHtml::closeTag("ul");
	
				// $html .= CHtml::link($linkBody, "http://www.ebay.com/itm/$itemId",
				// array('title'=>'click to view', 'target'=>'_blank'));
				$html .= CHtml::link($linkBody, $item['viewItemUrl'],
						array('title'=>'click to view', 'target'=>'_blank'));
				$html .= CHtml::closeTag("td");
			}
			$html .= CHtml::closeTag("tr");
		}
	
		$html .= CHtml::closeTag("table");
	
		return $html;
	}
	
	function build_shopwindow_topmost($rss = false)
	{
		$shop_window_items = array();
		$count = 0;
	
		$inventoryBean = BeanFactory::getBean('xInventories');
		$where = "id<>'{$this->id}' AND topmost='1'";
		$topmostItems = $inventoryBean->get_list("", $where, 0, -99, -99, 0, false, array('id'));
	
		foreach ($topmostItems['list'] as &$topmostItem) {
			$res = $this->get_valid_listing_gallery($topmostItem->id);
			if ($res !== false) {
				$shop_window_items[] = $res;
				$count++;
				if ($count == self::shopwindow_stick_limit)
					break;
			}
		}
	
		$padding = $this->get_shop_window_items_random(self::shopwindow_stick_limit - $count);
		$shop_window_items = array_merge($shop_window_items, $padding);
	
		return $this->build_shopwindow_html($shop_window_items, 1, self::shopwindow_stick_limit, $rss);
	}
	
	function build_shopwindow_correlation($rss = false)
	{
		$shop_window_items = array();
		$count = 0;
	
		$inventory = BeanFactory::getBean('xInventories', $this->xinventory_id);
		if ($inventory !== false) {
			$idGroup = array();
			$inventory->load_relationship('xinventorygroups');
			$groups = $inventory->xinventorygroups->getBeans();
			foreach($groups as &$group) {
				$group->load_relationship('xinventories');
				$ids = $group->xinventories->get();
				foreach ($ids as &$id) {
					$res = $this->get_valid_listing_gallery($id);
					if ($res !== false) {
						$shop_window_items[] = $res;
						$count++;
						if ($count == self::shopwindow_correlation_limit)
							break;
					}
				}
			}
		}
	
		$padding = $this->get_shop_window_items_random(self::shopwindow_correlation_limit - $count);
		$shop_window_items = array_merge($shop_window_items, $padding);
	
		return $this->build_shopwindow_html($shop_window_items, self::shopwindow_correlation_limit, 1, $rss);
	}
	
	function build_shopwindow_random($rss = false)
	{
		return $this->build_shopwindow_html($this->get_shop_window_items_random(self::shopwindow_random_limit), 3, 4, $rss);
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

function get_listing_status_array($add_blank=true)
{
	return array(
		'' => '',
		'Active' => 'Active',
		'Completed' => 'Completed',
		'Ended' => 'Ended',
	);
}

function get_listing_type_array($add_blank=true)
{
	return array(
		'' => '',
		'AdType' => 'AdType',
		'Chinese' => 'Chinese',
		'FixedPriceItem' => 'FixedPriceItem',
		'LeadGeneration' => 'LeadGeneration',
	);
}

?>
