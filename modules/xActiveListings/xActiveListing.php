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
	var $sku;
	var $variation;
	var $parent_id;
	var $parent_type;

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

    function save($check_notify = FALSE)
	{
		$inventory = BeanFactory::getBean('xInventories');
		$this->parent_id = '';
		$this->parent_type = '';
		$sku = $this->sku;
		if (!empty($sku)) {
			$inv = $inventory->retrieve_by_string_fields(array('sku' => $sku));
			$len = strlen($sku);
			if($inv != null) {
				$this->parent_id = $inv->id;
				$this->parent_type = 'xInventories';
			}
		}
		parent::save(check_notify);
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
        $html = "desc $count $row x $column: ";

        foreach ($items as &$item) {
            $html = $html . "~" . $item['title'] . "~";
        }

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
			$inventory = $inventoryBean->retrieve($item->parent_id);
			$activeListing = $activeListingBean->get_valid_listing($item->parent_id);
			if (($inventory !== null) && ($activeListing !== null)) {
				$shop_window_items[] = array(
					'itemID' => $activeListing->item_id,
                    'title' => empty($inventory->subtitle) ? $activeListing->name : $inventory->subtitle,
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
			$inventory = $inventoryBean->retrieve($item->parent_id);
			if ($inventory !== null) {
				$shop_window_items[] = array(
					'itemID' => $item->item_id,
                    'title' => empty($inventory->subtitle) ? $item->name : $inventory->subtitle,
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
			$inventory = $inventoryBean->retrieve($item->parent_id);
			if ($inventory !== null) {
				$shop_window_items[] = array(
					'itemID' => $item->item_id,
                    'title' => empty($inventory->subtitle) ? $item->name : $inventory->subtitle,
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

	function get_description()
	{
        $inventoryBean = BeanFactory::getBean('xInventories');
        $note = BeanFactory::getBean('Notes');
 
        $ss = new Sugar_Smarty();
        $ss->assign("SHOPWINDOW_STICK", $this->build_shopwindow_stick());
        $ss->assign("SHOPWINDOW_CORRELATION", $this->build_shopwindow_correlation());
        $ss->assign("SHOPWINDOW_RANDOM", $this->build_shopwindow_random());
        $desc = $ss->fetch("modules/xActiveListings/tpls/default.tpl");
 
        unset($ss);
 
        return $desc;
	}
}
?>
