<?php
/**
 * sources
 */
require_once 'eBayTradingApi.php';
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
class GetSellerList extends eBayTradingApi
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
			'ItemArray.Item.ApplicationData',
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

	function fill_picture_details(&$item)
	{
		$xmlString = "<?xml version='1.0' standalone='yes'?><PictureDetails></PictureDetails>";
		$xml = simplexml_load_string($xmlString);

		$pictureURL = $item->getPictureDetails()->getPictureURL();
		foreach ($pictureURL as &$url) {
			$xml->addChild('PictureURL', $url);
		}

        return htmlentities($xml->asXML(), ENT_QUOTES, 'UTF-8');
	}

	public function retrieveSellerList($params)
	{
		$account_id = $params['AccountID'];
		$this->session->setRequestToken($params['AuthToken']);

		$result = true;

		$bean = BeanFactory::getBean('xeBaySellerLists');

		$outputSelector = array(
			'HasMoreItems',
			'ItemArray.Item.ApplicationData',
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
					$bean->xebayaccount_id = $account_id;
					$bean->xebaylisting_id = xeBayListing::uuid_to_guid($item->getApplicationData());
					$bean->hitcount = $item->getHitCount();;
					$bean->item_id = $item->getItemID();
					$bean->currency_id = $item->getListingDetails()->getConvertedStartPrice()->getTypeAttribute('currencyID');
					$bean->price = $item->getListingDetails()->getConvertedStartPrice()->getTypeValue();
					$bean->endtime = $item->getListingDetails()->getEndTime();
					$bean->view_item_url = $item->getListingDetails()->getViewItemURL();
					$bean->listing_type = $item->getListingType();
					if ($bean->listing_type == 'PersonalOffer')
						continue;
					$bean->picture_details = $this->fill_picture_details($item);
					$bean->bid_count = $item->getSellingStatus()->getBidCount();
					$bean->quantity = $item->getQuantity();
					$bean->xinventory_id = $item->getSKU();
                    $bean->name = $item->getTitle();
					$variations = $item->getVariations();
					$bean->variation = !empty($variations);
					$bean->id = create_guid();
					$bean->new_with_id = true;
					$bean->save();
				}
			} else {
            	$this->dumpObject($res);
				$result = false;
				break;
			}
		} while ($hasMoreItems);

		return $result;
	}

	public function retrieveSellerSurveyList($params)
	{
		$this->session->setRequestToken($params['AuthToken']);
		$xebayuser_id = $params['xeBayUserID'];

		$bean = BeanFactory::getBean('xeBaySellerSurveys');
		$GLOBALS['db']->query("DELETE FROM xebaysellersurveys WHERE xebaysellersurveys.xebayuser_id ='{$params['xeBayUserID']}'");

		$outputSelector = array(
			'HasMoreItems',
            'ItemArray.Item.BuyItNowPrice',
			// 'ItemArray.Item.Currency',
			'ItemArray.Item.ItemID',
			'ItemArray.Item.ListingDetails.ConvertedStartPrice',
			'ItemArray.Item.ListingDetails.StartTime',
			'ItemArray.Item.ListingDetails.EndTime',
			'ItemArray.Item.ListingDetails.ViewItemURL',
			'ItemArray.Item.ListingType',
			'ItemArray.Item.PictureDetails.PictureURL',
			'ItemArray.Item.PrimaryCategory',
			'ItemArray.Item.Quantity',
			'ItemArray.Item.SellingStatus.QuantitySold',
			'ItemArray.Item.StartPrice',
			'ItemArray.Item.Title',
			'Seller.UserID',
			'ItemsPerPage',
			'PageNumber',
			'ReturnedItemCountActual',
		);

        $req = new GetSellerListRequestType();
		$req->setDetailLevel('ReturnAll');
		$req->setEndTimeFrom($params['EndTimeFrom']);
		$req->setEndTimeTo($params['EndTimeTo']);
		$req->setUserID($params['UserID']);
		$req->setOutputSelector($outputSelector);

		$pagination = new PaginationType();
		$pagination->setEntriesPerPage(200);
		$pageNumber = 1;

		$returnedItemCountActual = 0;
		$hasMoreItems = false;
		do {
			$pagination->setPageNumber($pageNumber++);
			$req->setPagination($pagination);
        	$res = $this->proxy->GetSellerList($req);
        	if ($this->testValid($res)) {
				$hasMoreItems = $res->getHasMoreItems();
				$returnedItemCountActual += $res->getReturnedItemCountActual();
				$userID = $res->getSeller()->getUserID();
				$itemArray = $res->getItemArray();
				if (empty($itemArray))
					break;
				foreach ($itemArray as &$item) {
					$bean->listing_type = $item->getListingType();
                    $listingType = $item->getListingType();
					if (($listingType != 'FixedPriceItem') && ($listingType != 'StoresFixedPrice'))
						continue;
				    $bean->quantitysold = $item->getSellingStatus()->getQuantitySold();
					// if ($bean->quantitysold  == 0)
						// continue;
				    $bean->buyitnowprice = $item->getBuyItNowPrice()->getTypeValue();
				    $bean->buyitnowprice_currencyid = $item->getBuyItNowPrice()->getTypeAttribute('currencyID');
				    $bean->itemid = $item->getItemID();
				    $bean->convertedstartprice = $item->getListingDetails()->getConvertedStartPrice()->getTypeValue();
				    $bean->convertedstartprice_currencyid = $item->getListingDetails()->getConvertedStartPrice()->getTypeAttribute('currencyID');
				    $bean->starttime = $item->getListingDetails()->getStartTime();
				    $bean->endtime = $item->getListingDetails()->getEndTime();
				    $bean->viewitemurl = $item->getListingDetails()->getViewItemURL();
				    $bean->picturedetails = $this->fill_picture_details($item);
				    $bean->categoryid = $item->getPrimaryCategory()->getCategoryID();
				    $bean->categoryname = $item->getPrimaryCategory()->getCategoryName();
				    $bean->quantity = $item->getQuantity();
					$bean->quantitysold_permonth = $bean->quantitysold * 30 / ((time() - strtotime($bean->starttime)) / (60 * 60 * 24));
				    $bean->startprice = $item->getStartPrice()->getTypeValue();
				    $bean->startprice_currencyid = $item->getStartPrice()->getTypeAttribute('currencyID');
                    $bean->name = $item->getTitle();
					$bean->xebayuser_id = $xebayuser_id;
					$bean->id = create_guid();
					$bean->new_with_id = true;
					$bean->save();
				}
			} else {
            	$this->dumpObject($res);
				return false;
			}
		} while ($hasMoreItems);

		return $returnedItemCountActual;
	}
}

?>
