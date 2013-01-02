<?php
/**
 * sources
 */
require_once 'eBayApiEnvironment.php';
require_once 'GeteBayDetailsRequestType.php';

/**
 * sample_GeteBayDetailss
 * 
 * Sample call for GeteBayDetailss
 * 
 * @package ebatns
 * @subpackage samples_trading
 * @author johann 
 * @copyright Copyright (c) 2008
 * @version $Id: sample_GeteBayDetailss.php,v 1.107 2012-09-10 11:01:21 michaelcoslar Exp $
 * @access public
 */
class GeteBayDetails extends eBayApiEnvironment
{

   /**
     * sample_GeteBayDetails::dispatchCall()
     * 
     * Dispatch the call
     *
     * @param array $params array of parameters for the eBay API call
     * 
     * @return boolean success
     */
    public function dispatchCall ($params)
    {
        $req = new GeteBayDetailsRequestType();
		if (isset($params['DetailName']))
			$req->setDetailName($params['DetailName']);
		
        $res = $this->proxy->GeteBayDetails($req);
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


	public function fill_ebay_details($bean, $res, $xml)
	{
		$xmlString = "<?xml version='1.0' standalone='yes'?><eBayDetails></eBayDetails>";
		$xml = simplexml_load_string($xmlString);
		$this->fill_buyer_requirement_details($bean, $res, $xml);
		$this->fill_country_details($bean, $res, $xml);
		$this->fill_currency_details($bean, $res, $xml);
		$this->fill_dipatch_time_max_details($bean, $res, $xml);
		$this->fill_exclude_shipping_location_details($bean, $res, $xml);
		$this->fill_item_specific_details($bean, $res, $xml);
		$this->fill_listing_feature_details($bean, $res, $xml);
		$this->fill_listing_start_price_details($bean, $res, $xml);
		$this->fill_payment_option_details($bean, $res, $xml);
		$this->fill_recoupment_policy_details($bean, $res, $xml);
		$this->fill_region_details($bean, $res, $xml);
		$this->fill_region_of_origin_details($bean, $res, $xml);
		$this->fill_return_policy_details($bean, $res, $xml);
		$this->fill_shipping_carrier_details($bean, $res, $xml);
		$this->fill_shipping_category_details($bean, $res, $xml);
		$this->fill_shipping_location_details($bean, $res, $xml);
		$this->fill_shipping_service_details($bean, $res, $xml);
		$this->fill_site_details($bean, $res, $xml);
		$this->fill_url_details($bean, $res, $xml);
		$this->fill_variation_details($bean, $res, $xml);

		$file = "modules/xeBayAccounts/xmls/" . $bean->id . ".xml";
		file_put_contents($file, $xml->asXML());
	}

	public function fill_buyer_requirement_details($bean, $res, $xml)
	{
		$details = $res->getBuyerRequirementDetails();
		if (empty($details))
			return;

		$xmlSub = $xml->addChild('BuyerRequirementDetails');
		foreach($details as &$detail) {
			$child = $xmlSub->addChild('BuyerRequirementDetail');
			$child->addChild('LinkedPayPalAccount', $detail->getLinkedPayPalAccount());

			$subChild = $child->addChild('MaximumBuyerPolicyViolations');
			$numberOfPolicyViolations = $detail->getMaximumBuyerPolicyViolations()->getNumberOfPolicyViolations();
			foreach ($numberOfPolicyViolations as &$value) {
				$subChild->addChild('NumberOfPolicyViolation', $value);
			}
			$policyViolationDuration = $detail->getMaximumBuyerPolicyViolations()->getPolicyViolationDuration();
			foreach ($policyViolationDuration as &$value) {
				$e = $subChild->addChild('NumberOfPolicyViolation');
				$e->addChild('Description', $value->getDescription());
				$e->addChild('Period', $value->getPeriod());
			}

			$subChild = $child->addChild('MaximumItemRequirements');
			$maximumItemRequirements = $detail->getMaximumItemRequirements()->getMaximumItemCount();
			foreach ($maximumItemRequirements as &$value) {
				$subChild->addChild("MaximumItemCount", $value);
			}
			$minimumFeedbackScore = $detail->getMaximumItemRequirements()->getMinimumFeedbackScore();
			foreach ($minimumFeedbackScore as &$value) {
				$subChild->addChild("MinimumFeedbackScore", $value);
			}

			$subChild = $child->addChild('MaximumUnpaidItemStrikesInfo');
			$maximumUnpaidItemStrikesCount = $detail->getMaximumUnpaidItemStrikesInfo()->getMaximumUnpaidItemStrikesCount();
			foreach ($maximumUnpaidItemStrikesCount as &$value) {
				$subChild->addChild("MaximumUnpaidItemStrikesCount", $value);
			}
			$maximumUnpaidItemStrikesDuration = $detail->getMaximumUnpaidItemStrikesInfo()->getMaximumUnpaidItemStrikesDuration();
			foreach ($maximumUnpaidItemStrikesDuration as &$value) {
				$e = $subChild->addChild("MaximumUnpaidItemStrikesDuration");
				$e->addChild('Description', $value->getDescription());
				$e->addChild('Period', $value->getPeriod());
			}

			$subChild = $child->addChild('MinimumFeedbackScore');
			$feedbackScore = $detail->getMinimumFeedbackScore()->getFeedbackScore();
			foreach ($feedbackScore as &$value) {
				$subChild->addChild("FeedbackScore", $value);
			}

			$child->addChild('ShipToRegistrationCountry', $detail->getShipToRegistrationCountry());

			$subChild = $child->addChild('VerifiedUserRequirements');
			$verifiedUserRequirements = $detail->getVerifiedUserRequirements();
			if ($verifiedUserRequirements !== null) {
				$feedbackScore = $verifiedUserRequirements()->getFeedbackScore();
				foreach ($feedbackScore as &$value) {
					$subChild->addChild("FeedbackScore", $value);
				}
				$subChild->addChild("VerifiedUser", $verifiedUserRequirements()->getVerifiedUser());
			}
		}
	}

	public function fill_country_details($bean, $res, $xml)
	{
		$details = $res->getCountryDetails();
		if (empty($details))
			return;

		$xmlSub = $xml->addChild('CountryDetails');
		foreach($details as &$detail) {
			$xmlSub->addChild($detail->getCountry(), $detail->getDescription());
		}
	}

	public function fill_currency_details($bean, $res, $xml)
	{
		$details = $res->getCurrencyDetails();
		if (empty($details))
			return;

		$xmlSub = $xml->addChild('CurrencyDetails');
		foreach($details as &$detail) {
			$xmlSub->addChild($detail->getCurrency(), $detail->getDescription());
		}
	}

	public function fill_dipatch_time_max_details($bean, $res, $xml)
	{
		$details = $res->getDispatchTimeMaxDetails();
		if (empty($details))
			return;

		$xmlSub = $xml->addChild('DispatchTimeMaxDetails');
		foreach($details as &$detail) {
			$child = $xmlSub->addChild('DispatchTimeMaxDetail');
			$child->addChild('Description', $detail->getDescription());
			$child->addChild('DispatchTimeMax', $detail->getDispatchTimeMax());
		}
	}

	public function fill_exclude_shipping_location_details($bean, $res, $xml)
	{
		$details = $res->getExcludeShippingLocationDetails();
		if (empty($details))
			return;

		$xmlSub = $xml->addChild('ExcludeShippingLocationDetails');
		foreach($details as &$detail) {
			$child = $xmlSub->addChild('ExcludeShippingLocationDetail');
			$child->addChild('Description', $detail->getDescription());
			$child->addChild('Location', $detail->getLocation());
			$child->addChild('Region', $detail->getRegion());
		}

	}

	public function fill_item_specific_details($bean, $res, $xml)
	{
		$details = $res->getItemSpecificDetails();
		if (empty($details))
			return;

		$xmlSub = $xml->addChild('ItemSpecificDetails');
		foreach($details as &$detail) {
			$child = $xmlSub->addChild('ItemSpecificDetail');
			$child->addChild('MaxCharactersPerName', $detail->getMaxCharactersPerName());
			$child->addChild('MaxCharactersPerValue', $detail->getMaxCharactersPerValue());
			$child->addChild('MaxItemSpecificsPerItem', $detail->getMaxItemSpecificsPerItem());
			$child->addChild('MaxValuesPerName', $detail->getMaxValuesPerName());
		}
	}

	public function fill_listing_feature_details($bean, $res, $xml)
	{
		$details = $res->getListingFeatureDetails();
		if (empty($details))
			return;

		$xmlSub = $xml->addChild('ListingFeatureDetails');
		foreach($details as &$detail) {
			$child = $xmlSub->addChild('ListingFeatureDetail');
			$child->addChild('BoldTitle', $detail->getBoldTitle());
			$child->addChild('Border', $detail->getBorder());
			$child->addChild('Highlight', $detail->getHighlight());
			$child->addChild('GiftIcon', $detail->getGiftIcon());
			$child->addChild('HomePageFeatured', $detail->getHomePageFeatured());
			$child->addChild('FeaturedFirst', $detail->getFeaturedFirst());
			$child->addChild('FeaturedPlus', $detail->getFeaturedPlus());
			$child->addChild('ProPack', $detail->getProPack());
		}
	}

	public function fill_listing_start_price_details($bean, $res, $xml)
	{
		$details = $res->getListingStartPriceDetails();
		if (empty($details))
			return;

		$xmlSub = $xml->addChild('ListingStartPriceDetails');
		foreach($details as &$detail) {
			$child = $xmlSub->addChild('ListingStartPriceDetail');
			$child->addChild('Description', $detail->getDescription());
			$child->addChild('ListingType', $detail->getListingType());
			$child->addChild('MinBuyItNowPricePercent', $detail->getMinBuyItNowPricePercent());
			$child->addChild('StartPrice', $detail->getStartPrice()->getTypeValue());
			$child->addChild('currencyID', $detail->getStartPrice()->getTypeAttribute('currencyID'));
		}
	}

	public function fill_payment_option_details($bean, $res, $xml)
	{
		$details = $res->getPaymentOptionDetails();
		if (empty($details))
			return;

		$xmlSub = $xml->addChild('PaymentOptionDetails');
		foreach($details as &$detail) {
			$child = $xmlSub->addChild('PaymentOptionDetail');
			$child->addChild('Description', $detail->getDescription());
			$child->addChild('PaymentOption', $detail->getPaymentOption());
		}
	}

	public function fill_recoupment_policy_details($bean, $res, $xml)
	{
		$details = $res->getRecoupmentPolicyDetails();

		if (empty($details))
			return;

		$xmlSub = $xml->addChild('RecoupmentPolicyDetails');
		foreach($details as &$detail) {
			$child = $xmlSub->addChild('RecoupmentPolicyDetail');
			$child->addChild('EnforcedOnListingSite', $detail->getEnforcedOnListingSite());
			$child->addChild('EnforcedOnRegistrationSite', $detail->getEnforcedOnRegistrationSite());
		}
	}

	public function fill_region_details($bean, $res, $xml)
	{
		$details = $res->getRegionDetails();

		if (empty($details))
			return;

		$xmlSub = $xml->addChild('RegionDetails');
		foreach($details as &$detail) {
			$child = $xmlSub->addChild('RegionDetail');
			$child->addChild('Description', $detail->getDescription());
			$child->addChild('RegionID', $detail->getRegionID());
		}
	}

	public function fill_region_of_origin_details($bean, $res, $xml)
	{
		$details = $res->getRegionOfOriginDetails();

		if (empty($details))
			return;

		$xmlSub = $xml->addChild('RegionOfOriginDetails');
		foreach($details as &$detail) {
			$child = $xmlSub->addChild('RegionOfOriginDetail');
			$child->addChild('Description', $detail->getDescription());
			$child->addChild('RegionOfOrigin', $detail->getRegionOfOrigin());
		}
	}

	public function fill_return_policy_details($bean, $res, $xml)
	{
		$details = $res->getReturnPolicyDetails();

		if (empty($details))
			return;

		$xmlSub = $xml->addChild('ReturnPolicyDetails');
		$xmlSub->addChild('Description', $details->getDescription());
		$xmlSub->addChild('EAN', $details->getEAN());

		$refunds = $details->getRefund();
		foreach($refunds as &$refund) {
			$child = $xmlSub->addChild('Refund');
			$child->addChild('Description', $refund->getDescription());
			$child->addChild('RefundOption', $refund->getRefundOption());
		}

		$restockingFeeValues = $details->getRestockingFeeValue();
		foreach($restockingFeeValues as &$restockingFeeValue) {
			$child = $xmlSub->addChild('RestockingFeeValue');
			$child->addChild('Description', $restockingFeeValue->getDescription());
			$child->addChild('RestockingFeeValueOption', $restockingFeeValue->getRestockingFeeValueOption());
		}

		$returnsAccepteds = $details->getReturnsAccepted();
		foreach($returnsAccepteds as &$returnsAccepted) {
			$child = $xmlSub->addChild('ReturnsAccepted');
			$child->addChild('Description', $returnsAccepted->getDescription());
			$child->addChild('ReturnsAcceptedOption', $returnsAccepted->getReturnsAcceptedOption());
		}

		$returnsWithins = $details->getReturnsWithin();
		foreach($returnsWithins as &$returnsWithin) {
			$child = $xmlSub->addChild('ReturnsWithin');
			$child->addChild('Description', $returnsWithin->getDescription());
			$child->addChild('ReturnsWithinOption', $returnsWithin->getReturnsWithinOption());
		}

		$shippingcostPaidBys = $details->getShippingcostPaidBy();
		foreach($shippingcostPaidBys as &$shippingcostPaidBy) {
			$child = $xmlSub->addChild('ShippingcostPaidBy');
			$child->addChild('Description', $shippingcostPaidBy->getDescription());
			$child->addChild('ShippingcostPaidByOption', $shippingcostPaidBy->getShippingcostPaidByOption());
		}

		$warrantyDurations = $details->getWarrantyDuration();
		if ($warrantyDurations !== null) {
			foreach($warrantyDurations as &$warrantyDuration) {
				$child = $xmlSub->addChild('WarrantyDuration');
				$child->addChild('Description', $warrantyDuration->getDescription());
				$child->addChild('WarrantyDurationOption', $warrantyDuration->getWarrantyDurationOption());
			}
		}

		$warrantyOffereds = $details->getWarrantyOffered();
		if ($warrantyOffereds !== null) {
			foreach($warrantyOffereds as &$warrantyOffered) {
				$child = $xmlSub->addChild('WarrantyOffered');
				$child->addChild('Description', $warrantyOffered->getDescription());
				$child->addChild('WarrantyOfferedOption', $warrantyOffered->getWarrantyOfferedOption());
			}
		}

		if ($warrantyTypes !== null) {
			$warrantyTypes = $details->getWarrantyType();
			foreach($warrantyTypes as &$warrantyType) {
				$child = $xmlSub->addChild('WarrantyType');
				$child->addChild('Description', $warrantyType->getDescription());
				$child->addChild('WarrantyTypeOption', $warrantyType->getWarrantyTypeOption());
			}
		}
	}

	public function fill_shipping_carrier_details($bean, $res, $xml)
	{
		$details = $res->getShippingCarrierDetails();
		if (empty($details))
			return;

		$xmlSub = $xml->addChild('ShippingCarrierDetails');
		foreach($details as &$detail) {
			$child = $xmlSub->addChild('ShippingCarrierDetail');
			$child->AddChild('Description', $detail->getDescription());
			$child->addChild('ShippingCarrier', $detail->getShippingCarrier());
			$child->addChild('ShippingCarrierID', $detail->getShippingCarrierID());
		}
	}

	public function fill_shipping_category_details($bean, $res, $xml)
	{
		$details = $res->getShippingCategoryDetails();
		if (empty($details))
			return;

		$xmlSub = $xml->addChild('ShippingCategoryDetails');
		foreach($details as &$detail) {
			$xmlSub->addChild($detail->getShippingCategory(), $detail->getDescription());
		}
	}

	public function fill_shipping_location_details($bean, $res, $xml)
	{
		$details = $res->getShippingLocationDetails();
		if (empty($details))
			return;

		$xmlSub = $xml->addChild('ShippingLocationDetails');
		foreach($details as &$detail) {
			$xmlSub->addChild($detail->getShippingLocation(), $detail->getDescription());
		}
	}

	public function fill_shipping_service_details($bean, $res, $xml)
	{
		$details = $res->getShippingServiceDetails();
		if (empty($details))
			return;

		$xmlSub = $xml->addChild('ShippingServiceDetails');
		foreach($details as &$detail) {
			$child = $xmlSub->addChild('ShippingServiceDetail');
			$child->addChild('Description', $detail->getDescription());
			$child->addChild('DimensionsRequired', $detail->getDimensionsRequired());
			$child->addChild('ExpeditedService', $detail->getExpeditedService());
			$child->addChild('InternationalService', $detail->getInternationalService());
			$child->addChild('MappedToShippingServiceID', $detail->getMappedToShippingServiceID());
			$serviceType = $detail->getServiceType();
			if ($serviceType !== null) {
				foreach($serviceType as &$service) {
					$child->addChild('ServiceType', $service);
				}
			}
			$shippingCarrier = $detail->getShippingCarrier();
			if ($shippingCarrier !== null) {
				foreach($shippingCarrier as &$carrier) {
					$child->addChild('ShippingCarrier', $carrier);
				}
			}
			$child->addChild('ShippingCategory', $detail->getShippingCategory());
			$shippingPackage = $detail->getShippingPackage();
			if ($shippingPackage) {
				foreach($shippingPackage as &$package) {
					$child->addChild('ShippingPackage', $package);
				}
			}
			$child->addChild('ShippingService', $detail->getShippingService());
			$child->addChild('ShippingServiceID', $detail->getShippingServiceID());
			$child->addChild('ShippingTimeMax', $detail->getShippingTimeMax());
			$child->addChild('ShippingTimeMin', $detail->getShippingTimeMin());
			$child->addChild('SurchargeApplicable', $detail->getSurchargeApplicable());
			$child->addChild('ValidForSellingFlow', $detail->getValidForSellingFlow());
			$child->addChild('WeightRequired', $detail->getWeightRequired());
		}
	}

	public function fill_site_details($bean, $res, $xml)
	{
		$siteDetails = $res->getSiteDetails();
		if (empty($siteDetails))
			return;

		$xmlSub = $xml->addChild('SiteDetails');
		foreach($siteDetails as &$detail) {
			$xmlSub->addChild($detail->getSite(), $detail->getSiteID());
		}
	}

	public function fill_url_details($bean, $res, $xml)
	{
		$urlDetails = $res->getURLDetails();
		if (empty($urlDetails))
			return;

		$xmlSub = $xml->addChild('URLDetails');
		foreach($urlDetails as &$detail) {
			$child = $xmlSub->addChild($detail->getURLType());
			$child->{0} = $detail->getURL();
		}
	}

	public function fill_variation_details($bean, $res, $xml)
	{
		$variationDetails = $res->getVariationDetails();
		if (empty($variationDetails))
			return;

		$xmlSub = $xml->addChild('VariationDetails');
		$xmlSub->addChild('MaxVariationsPerItem', $variationDetails->getMaxVariationsPerItem());
		$xmlSub->addChild('MaxNamesPerVariationSpecificsSet', $variationDetails->getMaxNamesPerVariationSpecificsSet());
		$xmlSub->addChild('MaxValuesPerVariationSpecificsSetName', $variationDetails->getMaxValuesPerVariationSpecificsSetName());
	}

	public function retrieveeBayDetails($params)
	{
		$account_id = $params['AccountID'];
		$this->session->setRequestToken($params['AuthToken']);

		$bean = BeanFactory::getBean('xeBayAccounts');
		if ($bean->retrieve($account_id) === null)
			return false;

        $req = new GeteBayDetailsRequestType();
		if (isset($params['DetailName']))
			$req->setDetailName($params['DetailName']);

        $res = $this->proxy->GeteBayDetails($req);
        if ($this->testValid($res)) {
			$this->fill_ebay_details($bean, $res, $xml);
			$bean->ebay_detail_update_time = $res->getUpdateTime();
			$bean->save();
            return (true);
        } else {
            $this->dumpObject($res);
            return (false);
        }
	}
}

?>
