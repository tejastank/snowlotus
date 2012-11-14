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

class xActiveListing extends Basic {
	var $new_schema = true;
	var $module_dir = 'xActiveListings';
	var $object_name = 'xActiveListing';
	var $table_name = 'xactivelistings';
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

	var $hitcount;
	var $item_id;
	var $currency_id;
	var $price;
	var $endtime;
	var $view_item_url;
	var $listing_type;
	var $bid_count;
	var $quantity;
	var $variation;
	var $inventory_id;

	const shopwindow_stick_limit = 6;
	const shopwindow_correlation_limit = 9;
	const shopwindow_random_limit = 12;

	function xActiveListing()
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

		return $field_list;
	}

	function get_valid_listing($item_id)
	{
		$activeListingBean = BeanFactory::getBean('xActiveListings');

		$fields = array(
			'id' => $item_id,
			'listing_type' => 'FixedPirceItem',
		);

		$activeListing = $activeListingBean->retrieve_by_string_fields($fields);

		// if ($activeListing !== null) {
			// if ($activeListing->endtime > 7)
		// }

		return $activeListing;
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

	function build_shopwindow_stick()
	{
		$inventoryBean = BeanFactory::getBean('xInventories');
		$pinnedItemBean = BeanFactory::getBean('xPinnedItems');
		$activeListingBean = BeanFactory::getBean('xActiveListings');
		$note = BeanFactory::getBean('Notes');

		$pinnedItems = $pinnedItemBean->get_full_list();

		$shop_window_items = array();

		$count = 0;

		foreach ($pinnedItems as &$item) {
			$inventory = $inventoryBean->retrieve($item->inventory_id);
			$activeListing = $activeListingBean->get_valid_listing($item->inventory_id);
			if (($inventory !== null) && ($activeListing !== null)) {
				$shop_window_items[] = array(
					'itemID' => $activeListing->item_id,
                    'title' => empty($inventory->subtitle) ? $activeListing->name : $inventory->subtitle,
					'listingType' => $activeListing->listing_type,
					'currencyID' => $activeListing->currency_id,
					'price' => $activeListing->price,
					'viewItemUrl' => $activeListing->view_item_url,
				);

				$count++;

				if ($count == self::shopwindow_stick_limit)
					break;
			}
		}

		if (count($shop_window_items) < self::shopwindow_stick_limit) {
		}

        return $this->build_shopwindow_html($shop_window_items, 1, self::shopwindow_stick_limit);
	}

	function build_shopwindow_correlation()
	{
		$inventoryBean = BeanFactory::getBean('xInventories');
		$activeListingBean = BeanFactory::getBean('xActiveListings');
		$randomItems = $activeListingBean->get_full_list("", "listing_type='FixedPriceItem' AND item_id<>'$this->id'");

		$shop_window_items = array();

		$count = 0;

		foreach ($randomItems as &$item) {
			$inventory = $inventoryBean->retrieve($item->inventory_id);
			if ($inventory !== null) {
				$shop_window_items[] = array(
					'itemID' => $item->item_id,
                    'title' => empty($inventory->subtitle) ? $item->name : $inventory->subtitle,
					'listingType' => $item->listing_type,
					'currencyID' => $item->currency_id,
					'price' => $item->price,
					'viewItemUrl' => $item->view_item_url,
				);

				$count++;

				if ($count == self::shopwindow_correlation_limit)
					break;
			}
		}

		if (count($shop_window_items) < self::shopwindow_correlation_limit) {
		}

        return $this->build_shopwindow_html($shop_window_items, self::shopwindow_correlation_limit, 1);
	}

	function build_shopwindow_random()
	{
		$inventoryBean = BeanFactory::getBean('xInventories');
		$activeListingBean = BeanFactory::getBean('xActiveListings');
		$randomItems = $activeListingBean->get_full_list("", "listing_type='FixedPriceItem' AND item_id<>'$this->id'");

		$shop_window_items = array();

		$count = 0;

		foreach ($randomItems as &$item) {
			$inventory = $inventoryBean->retrieve($item->inventory_id);
			if ($inventory !== null) {
				$shop_window_items[] = array(
					'itemID' => $item->item_id,
                    'title' => empty($inventory->subtitle) ? $item->name : $inventory->subtitle,
					'listingType' => $item->listing_type,
					'currencyID' => $item->currency_id,
					'price' => $item->price,
					'viewItemUrl' => $item->view_item_url,
				);

				$count++;

				if ($count == self::shopwindow_random_limit)
					break;
			}
		}

		if (count($shop_window_items) < self::shopwindow_random_limit) {
		}

        return $this->build_shopwindow_html($shop_window_items, 3, 4);
	}

	function build_image_gallery()
	{
        $note = BeanFactory::getBean('Notes');
		$images = $note->get_full_list("", "parent_type='xActiveListings' AND parent_id='$this->id'");

		if (count($images) == 0)
			return "";

		$html = CHtml::openTag('div', array('id'=>'gallery'));
		$html .= CHtml::image($images[0], '', array("class"=>"default", 'width'=>450, 'height'=>450));
		$html .= CHtml::openTag('ul');
		foreach ($images as &$image) {
			$html .= CHtml::openTag('li');
			$linkBody = CHtml::image($images->description, '', array('width'=>50, 'height'=>50));
			$linkBody .= CHtml::openTag('b');
			$linkBody .= CHtml::openTag('span');
			$linkBody .= CHtml::closeTag('span');
			$linkBody .= CHtml::openTag('i');
			$linkBody .= CHtml::image($images->description, '', array('width'=>450, 'height'=>450));
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
        $inventoryBean = BeanFactory::getBean('xInventories');
    	$inv = $inventoryBean->retrieve($this->inventory_id);
		$desc = $this->name;
		if ($inv) {
			$body_html = $inv->body_html;
			if (!empty($body_html))
				$desc = html_entity_decode($body_html);
		}
		return $desc;
	}

	function get_description()
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
		$ss->assign("GALLERY", $this->build_image_gallery());
		$ss->assign("DESCRIPTION", $this->_get_description());
		$ss->assign("PACKAGE_INCLUDED", "");
        $ss->assign("SHOPWINDOW_STICK", $this->build_shopwindow_stick());
        $ss->assign("SHOPWINDOW_CORRELATION", $this->build_shopwindow_correlation());
        $ss->assign("SHOPWINDOW_RANDOM", $this->build_shopwindow_random());
        $desc = $ss->fetch("modules/xActiveListings/tpls/default.html");
		$desc = strtr($desc, $strips);
 
        unset($ss);

		file_put_contents($this->item_id . ".html", $desc);
 
        return $desc;
	}
}
?>
