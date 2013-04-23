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

require_once 'CHtml.php';

class xeBaySellerList extends Basic {
	var $new_schema = true;
	var $module_dir = 'xeBaySellerLists';
	var $object_name = 'xeBaySellerList';
	var $table_name = 'xebaysellerlists';
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

	var $xebayaccount_id;
    var $xebayaccount_name;
    var $xebaylisting_id;
    var $xebaylisting_name;
    var $xebaylisting_link;
	var $hitcount;
	var $item_id;
	var $currency_id;
	var $price;
	var $endtime;
	var $view_item_url;
	var $listing_type;
	var $picture_details;
	var $bid_count;
	var $quantity;
	var $variation;
	var $xinventory_id;

	var $xinventory_id_used = array();

	const shopwindow_stick_limit = 6;
	const shopwindow_correlation_limit = 10;
	const shopwindow_random_limit = 12;

	function xeBaySellerList()
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

    function save($check_notify = FALSE)
    {
        if (!empty($this->xebaylisting_id)) {
			$bean = BeanFactory::getBean('xeBayListings', $this->xebaylisting_id);
            $this->xinventory_id = $bean->xinventory_id;
        } else {
            $this->xinventory_id = '';
        }
        parent::save($check_notify);
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

	function get_valid_listing($inventory_id)
	{
		if (in_array($inventory_id, $this->xinventory_id_used)) {
			return null;
		}
		$this->xinventory_id_used[] = $inventory_id;

		$sellerListBean = BeanFactory::getBean('xeBaySellerLists');

		$fields = array(
			'xinventory_id' => $inventory_id,
			'listing_type' => 'FixedPriceItem',
		);

		$sellerList = $sellerListBean->retrieve_by_string_fields($fields);

		// if ($sellerList !== null) {
			// if ($sellerList->endtime > 7)
		// }

		return $sellerList;
	}

	function get_valid_listing_gallery($id)
	{
		$sellerList = $this->get_valid_listing($id);
		if ($sellerList !== null) {
        	$listing = BeanFactory::getBean('xeBayListings', $sellerList->xebaylisting_id);
			if ($listing !== false) {
				return array (
					'itemID' => $sellerList->item_id,
            	    'title' => empty($listing->short_title) ? $sellerList->name : $listing->short_title,
					'listingType' => $sellerList->listing_type,
					'currencyID' => $sellerList->currency_id,
					'price' => $sellerList->price,
					'viewItemUrl' => $sellerList->view_item_url,
				);
			}
		}
		return false;
	}

	function get_shop_window_items_random($max)
	{
		if ($max < 1)
			return array();

		$shop_window_items = array();
		$count = 0;

		$sellerListBean = BeanFactory::getBean('xeBaySellerLists');
		$where = "listing_type='FixedPriceItem' AND item_id<>'$this->item_id'";
		$sallerLists = $sellerListBean->get_list("", $where, 0, -99, -99, 0, false, array('xebaylisting_id', 'item_id', 'name', 'listing_type', 'currency_id', 'price', 'view_item_url'));
		shuffle($sallerLists['list']);

		foreach ($sallerLists['list'] as &$sellerList) {
        	$listing = BeanFactory::getBean('xeBayListings', $sellerList->xebaylisting_id);
			if (($listing !== false) && !in_array($listing->xinventory_id, $this->xinventory_id_used)) {
				$this->xinventory_id_used[] = $listing->xinventory_id;
				$shop_window_items[] = array(
					'itemID' => $sellerList->item_id,
                    'title' => empty($listing->short_title) ? $sellerList->name : $listing->short_title,
					'listingType' => $sellerList->listing_type,
					'currencyID' => $sellerList->currency_id,
					'price' => $sellerList->price,
					'viewItemUrl' => $sellerList->view_item_url,
				);

				$count++;

				if ($count == $max)
					break;
			}
		}

		return $shop_window_items;
	}

    function build_shopwindow_html($items, $row, $column)
    {
        $count = count($items);

		if ($count == 0)
			return "";

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

	function build_shopwindow_topmost()
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

        return $this->build_shopwindow_html($shop_window_items, 1, self::shopwindow_stick_limit);
	}

	function build_shopwindow_correlation()
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

        return $this->build_shopwindow_html($shop_window_items, self::shopwindow_correlation_limit, 1);
	}

	function build_shopwindow_random()
	{
        return $this->build_shopwindow_html($this->get_shop_window_items_random(self::shopwindow_random_limit), 3, 4);
	}

	function build_image_gallery()
	{
		$xml = simplexml_load_string(html_entity_decode($this->picture_details,ENT_COMPAT,'UTF-8'));
		$html = '';
		$html .= CHtml::openTag('div', array('id'=>'gallery'));
		$html .= CHtml::image($xml->PictureURL[0], '', array("class"=>"default", 'width'=>450));
		$html .= CHtml::openTag('ul');
		foreach ($xml->PictureURL as $url) {
			$html .= CHtml::openTag('li');
			$linkBody = CHtml::image($url, '', array('width'=>50));
			$linkBody .= CHtml::openTag('b');
			$linkBody .= CHtml::openTag('span');
			$linkBody .= CHtml::closeTag('span');
			$linkBody .= CHtml::openTag('i');
			$linkBody .= CHtml::image($url, '', array('width'=>450));
			$linkBody .= CHtml::closeTag('i');
			$linkBody .= CHtml::closeTag('b');
			$html .= CHtml::link($linkBody, '#x');
			$html .= CHtml::closeTag('li');
		}
		$html .= CHtml::closeTag('ul');
		$html .= CHtml::closeTag('div');

		return $html;
	}

	function _get_description()
	{
        $listing = BeanFactory::getBean('xeBayListings', $this->xebaylisting_id);
		$desc = $this->name;
		if ($listing !== false) {
			$body_html = $listing->description;
			if (!empty($body_html))
				$desc = html_entity_decode($body_html);
		}
		return $desc;
	}

	function get_description()
	{
		$this->xinventory_id_used = array();
		$this->xinventory_id_used[] = $this->xinventory_id;

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
		$ss->assign("GALLERY", $this->build_image_gallery());
		$ss->assign("DESCRIPTION", $this->_get_description());
		$ss->assign("PACKAGE_INCLUDED", "");
        $ss->assign("SHOPWINDOW_STICK", $this->build_shopwindow_topmost());
        $ss->assign("SHOPWINDOW_CORRELATION", $this->build_shopwindow_correlation());
        $ss->assign("SHOPWINDOW_RANDOM", $this->build_shopwindow_random());
        $desc = $ss->fetch("modules/xeBayListings/tpls/default.html");
		$desc = strtr($desc, $strips);
 
        unset($ss);
 
        return $desc;
	}

	function revise()
	{
		$ebayAccount = BeanFactory::getBean('xeBayAccounts');
		$accounts = $ebayAccount->get_accounts('All');
		$ri = new ReviseItem();
		$rfpi = new ReviseFixedPriceItem();
		$scope = array('description', 'sku');

		$authToken = $accounts[$this->xebayaccount_id];
		if (empty($this->variation)) {
			if ($this->bid_count > 0)
				continue;
			$ri->ryi(array(
				'ItemID' => $this->item_id,
				'Description' => $this->get_description(),
				'ApplicationData' => xeBayListing::guid_to_uuid($this->xebaylisting_id),
				'SKU' => $this->xinventory_id,
				'scope'=> $scope,
				'AuthToken' => $authToken,
			));
			$count++;
		} else {
			$rfpi->ryi(array(
				'ItemID' => $this->item_id,
				'Description' => $this->get_description(),
				'ApplicationData' => xeBayListing::guid_to_uuid($this->xebaylisting_id),
				'SKU' => $this->xinventory_id,
				'scope'=> $scope,
				'AuthToken' => $authToken,
			));
			$count++;
		}
	}
}

?>
