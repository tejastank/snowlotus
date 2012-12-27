<?php
/**
 * sources
 */
require_once 'eBayApiEnvironment.php';
require_once 'GetSellerListRequestType.php';

/**
 * sample_GetSellerList
 * 
 * Sample call for GetSellerList
 * 
 * @package ebatns
 * @subpackage samples_trading
 * @author johann 
 * @copyright Copyright (c) 2008
 * @version $Id: sample_GetSellerList.php,v 1.107 2012-09-10 11:01:21 michaelcoslar Exp $
 * @access public
 */
class GetSellerList extends eBayApiEnvironment
{

   /**
     * sample_GetSellerList::dispatchCall()
     * 
     * Dispatch the call
     *
     * @param array $params array of parameters for the eBay API call
     * 
     * @return boolean success
     */
    public function dispatchCall ($params)
    {
        $req = new GetSellerListRequestType();
		// $req->setErrorLanguage('zh_HK');
		$req->setDetailLevel('ReturnAll');
		$req->setIncludeVariations(true);
		$req->setEndTimeFrom($params['EndTimeFrom']);
		$req->setEndTimeTo($params['EndTimeTo']);
		
		$pageNumber = 1;
		$pagination = new PaginationType();
		$pagination->setEntriesPerPage(20);
		$pagination->setPageNumber($pageNumber);
		$req->setPagination($pagination);
		$outputSelector = array(
			'HasMoreItems',
			// 'ItemArray.Item.BuyItNowPrice',
			// 'ItemArray.Item.Currency',
			'ItemArray.Item.HitCount', /* may be not set */
			'ItemArray.Item.ItemID',
			'ItemArray.Item.ListingDetails.ConvertedStartPrice',
			'ItemArray.Item.ListingDetails.EndTime',
			'ItemArray.Item.ListingDetails.ViewItemURL',
			'ItemArray.Item.ListingDetails.ListingType',
			'ItemArray.Item.PictureDetails.PictureURL',
			'ItemArray.Item.Quantity',
			'ItemArray.Item.SellingStatus.BidCount',
			'ItemArray.Item.SKU', /* may be not set */
			'ItemArray.Item.Title',
			'ItemArray.Item.Variations',
			'ItemsPerPage',
			'PageNumber',
			'ReturnedItemCountActual',
		);

		$req->setOutputSelector($outputSelector);

        $res = $this->proxy->GetSellerList($req);
        if ($this->testValid($res))
        {
            $this->dumpObject($res);
            return (true);
        }
        else 
        {
            return (false);
        }
    }

	public function getActiveListing($params)
	{
		$account_id = $params['AccountID'];
		$this->session->setRequestToken($params['AuthToken']);

		$result = true;

		$bean = BeanFactory::getBean('xActiveListings');
		$inventory = BeanFactory::getBean('xInventories');
		$note = BeanFactory::getBean('Notes');

		$outputSelector = array(
			'HasMoreItems',
			// 'ItemArray.Item.BuyItNowPrice',
			// 'ItemArray.Item.Currency',
			'ItemArray.Item.HitCount', /* may be not set */
			'ItemArray.Item.ItemID',
			'ItemArray.Item.ListingDetails.ConvertedStartPrice',
			'ItemArray.Item.ListingDetails.EndTime',
			'ItemArray.Item.ListingDetails.ViewItemURL',
			'ItemArray.Item.ListingType',
			'ItemArray.Item.PictureDetails.PictureURL',
			'ItemArray.Item.Quantity',
			'ItemArray.Item.SellingStatus.BidCount',
			'ItemArray.Item.SKU', /* may be not set */
			'ItemArray.Item.Title',
			'ItemArray.Item.Variations',
			'ItemsPerPage',
			'PageNumber',
			'ReturnedItemCountActual',
		);

        $req = new GetSellerListRequestType();
		// $req->setErrorLanguage('zh_HK');
		$req->setDetailLevel('ReturnAll');
		$req->setIncludeVariations(true);
		$req->setEndTimeFrom($params['EndTimeFrom']);
		$req->setEndTimeTo($params['EndTimeTo']);
		$req->setOutputSelector($outputSelector);

		$pagination = new PaginationType();
		$pagination->setEntriesPerPage(100);
		$pageNumber = 1;

		$hasMoreItems = false;
		do {
			$pagination->setPageNumber($pageNumber++);
			$req->setPagination($pagination);
        	$res = $this->proxy->GetSellerList($req);
        	if ($this->testValid($res)) {
				$hasMoreItems = $res->getHasMoreItems();
				$returnedItemCountActual = $res->getReturnedItemCountActual();
				$itemArray = $res->getItemArray();
				if (empty($itemArray))
					break;
				foreach ($itemArray as &$item) {
					$bean->ebay_account_id = $account_id;
					$bean->hitcount = $item->getHitCount();;
					$bean->item_id = $item->getItemID();
					$bean->currency_id = $item->getListingDetails()->getConvertedStartPrice()->getTypeAttribute('currencyID');
					$bean->price = $item->getListingDetails()->getConvertedStartPrice()->getTypeValue();
					$bean->endtime = $item->getListingDetails()->getEndTime();
					$bean->view_item_url = $item->getListingDetails()->getViewItemURL();
					$bean->listing_type = $item->getListingType();
					if ($bean->listing_type == 'PersonalOffer')
						continue;
					$bean->bid_count = $item->getSellingStatus()->getBidCount();
					$bean->quantity = $item->getQuantity();
					$bean->inventory_id = $item->getSKU();
					$name = $bean->name = $item->getTitle();
					$variations = $item->getVariations();
					$bean->variation = !empty($variations);
					$bean->id = create_guid();
					$bean->new_with_id = true;
					$bean->save();

					$pictureURL = $item->getPictureDetails()->getPictureURL();
					if (empty($pictureURL))
						continue;
					$count = 0;
					foreach ($pictureURL as &$url) {
						$note->id = create_guid();
						$note->new_with_id = true;
						$note->parent_id = $bean->id;
						$note->parent_type = 'xActiveListings'; 
						$note_name = str_replace(' ', '-', strtolower(trim($name)));
						$note->name = "xactivelistings-" . $note_name . "-$count";
						$count++;
						$note->description = $url;
						$note->save();
					}
				}
			} else {
            	$this->dumpObject($res);
				$result = false;
				break;
			}
		} while ($hasMoreItems);

		return $result;
	}
}

?>
