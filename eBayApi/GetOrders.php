<?php
/**
 * sources
 */
require_once 'eBayTradingApi.php';
require_once 'GetOrdersRequestType.php';

/**
 * sample_GetOrders
 * 
 * Sample call for GetOrders
 * 
 * @package ebatns
 * @subpackage samples_trading
 * @author johann 
 * @copyright Copyright (c) 2008
 * @version $Id: sample_GetOrders.php,v 1.107 2012-09-10 11:01:21 michaelcoslar Exp $
 * @access public
 */
class GetOrders extends eBayTradingApi
{

   /**
     * sample_GetOrders::dispatchCall()
     * 
     * Dispatch the call
     *
     * @param array $params array of parameters for the eBay API call
     * 
     * @return boolean success
     */
    public function dispatchCall ($params)
    {
        $req = new GetOrdersRequestType();
        $req->setNumberOfDays($params['NumberOfDays']);
		$req->setOrderStatus($params['OrderStatus']);
		
        $res = $this->proxy->GetOrders($req);
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

	public function retrieveOrders($params)
	{
        global $sugar_config;
        $shipping_service = $sugar_config['ebay_shipping_service'];

		$result = true;
		$account_id = $params['AccountID'];
		$this->session->setRequestToken($params['AuthToken']);

		$bean = BeanFactory::getBean('xeBayOrders');

        $req = new GetOrdersRequestType();
		if ($params['NumberOfDays'] != 90) {
        	$req->setNumberOfDays($params['NumberOfDays']);
		} else {
			$req->setCreateTimeFrom(date('Y-m-dTH:i:s', strtotime('now - 88 days')));
		}
		$req->setOrderStatus($params['OrderStatus']);

		$pagination = new PaginationType();
		$pagination->setEntriesPerPage(50);
		$pageNumber = 1;

		$hasMoreOrders = false;
		do {
			$pagination->setPageNumber($pageNumber++);
			$req->setPagination($pagination);
        	$res = $this->proxy->GetOrders($req);
        	if ($this->testValid($res)) {
				$hasMoreOrders = $res->getHasMoreOrders();
				$ordersPerPage = $res->getOrdersPerPage();
				$orderArray = $res->getOrderArray();
				if (empty($orderArray))
					break;
				foreach ($orderArray as &$order) {
					$eBayPaymentStatus = $order->getCheckoutStatus()->getEBayPaymentStatus();
					if ($eBayPaymentStatus != "NoPaymentFailure")
						continue;

					$completeStatus = $order->getCheckoutStatus()->getStatus();
					if ($completeStatus != "Complete")
						continue;

					$orderId = $order->getOrderID();

					$duplicated = $bean->retrieve_by_string_fields(array('order_id'=>$orderId));

                    if (empty($duplicated)) {
                        $bean->shipping_service = $shipping_service;
                        $bean->populateDefaultValues(true);
                    }

					$bean->source_type = 'ebay';

					$bean->xebayaccount_id = $account_id;
					$bean->buyer_checkout_message = $order->getBuyerCheckoutMessage();;
					$bean->order_id = $order->getOrderID();
					$bean->order_status = $order->getOrderStatus();
					$bean->buyer_user_id = $order->getBuyerUserID();
					$bean->subtotal_currency_id = $order->getSubtotal()->getTypeAttribute('currencyID');
					$bean->subtotal_value = $order->getSubtotal()->getTypeValue();
					$bean->total_currency_id = $order->getTotal()->getTypeAttribute('currencyID');
					$bean->total_value = $order->getTotal()->getTypeValue();
					$bean->date_entered = $order->getCreatedTime();
					$bean->paid_time = $order->getPaidTime();
					$bean->shipped_time = $order->getShippedTime();
					if (!empty($bean->shipped_time)) {
						$bean->handled_status = 'handled';
                    } else if (empty($duplicated)) {
						$bean->handled_status = 'unhandled';
                    } else {
                        // do not change handled status
                    }
					$bean->sales_record_number = $order->getShippingDetails()->getSellingManagerSalesRecordNumber();
					$bean->eias_token = $order->getEIASToken();
					$bean->payment_hold_status = $order->getPaymentHoldStatus();

					$shippingAddress = $order->getShippingAddress();
        			$bean->name = $shippingAddress->getName();
					$bean->street1 = $shippingAddress->getStreet1();
					$bean->street2 = $shippingAddress->getStreet2();
					$bean->city_name = $shippingAddress->getCityName();
					$bean->state_or_province = $shippingAddress->getStateOrProvince();
					$bean->country = $shippingAddress->getCountry();
					$bean->country_name = $shippingAddress->getCountryName();
					$bean->phone = $shippingAddress->getPhone();
					$bean->postal_code = $shippingAddress->getPostalCode();
					$bean->address_id = $shippingAddress->getAddressID();
					$bean->address_owner = $shippingAddress->getAddressOwner();
					$bean->external_address_id = $shippingAddress->getExternalAddressID();

					if (empty($duplicated)) {
						$bean->checkout_status_last_modified_time = $order->getCheckoutStatus()->getLastModifiedTime();
						$bean->id = create_guid();
						$bean->new_with_id = true;
						$this->add_transactions($order->getTransactionArray(), $bean);
						$bean->save();
					} else {
						$checkoutStatusLastModifiedTime = $order->getCheckoutStatus()->getLastModifiedTime();
						if ($bean->checkout_status_last_modified_time != $checkoutStatusLastModifiedTime) {
							$bean->checkout_status_last_modified_time = $checkoutStatusLastModifiedTime;
							$bean->save();
						}
					}
				}
			} else {
            	$this->dumpObject($res);
				$result = false;
				break;
			}
		} while ($hasMoreOrders);

		return $result;
	}

	function add_transactions($transactions, $bean)
	{
		$orderTransaction = BeanFactory::getBean('xeBayTransactions');

		foreach ($transactions as &$transaction) {
			$duplicated = $orderTransaction->retrieve_by_string_fields(array('orderline_item_id'=>$transaction->getOrderLineItemID()));
			$orderTransaction->xebayorder_id = $bean->id;
			$orderTransaction->primitive_order_id = $bean->id;
            $actualHandlingCost = $transaction->getActualHandlingCost();
            if ($actualHandlingCost) {
			    $orderTransaction->actual_handling_cost_currency_id = $actualHandlingCost->getTypeAttribute('currencyID');
			    $orderTransaction->actual_handling_cost_value = $actualHandlingCost->getTypeValue();
            } else {
			    $orderTransaction->actual_handling_cost_currency_id = '';
			    $orderTransaction->actual_handling_cost_value = '';
            }
            $actualShippingCost = $transaction->getActualShippingCost();
            if ($actualShippingCost) {
			    $orderTransaction->actual_shipping_cost_currency_id = $actualShippingCost->getTypeAttribute('currencyID');
			    $orderTransaction->actual_shipping_cost_value = $actualShippingCost->getTypeValue();
            } else {
			    $orderTransaction->actual_shipping_cost_currency_id = '';
			    $orderTransaction->actual_shipping_cost_value = '';
            }
			$orderTransaction->date_entered = $transaction->getCreatedDate();
			$orderTransaction->item_item_id = $transaction->getItem()->getItemID();
			$orderTransaction->item_site = $transaction->getItem()->getSite();
			$orderTransaction->name =  $transaction->getItem()->getTitle();
			$orderTransaction->item_view_item_url = 'http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=' . $orderTransaction->item_item_id;
			$sku = $transaction->getItem()->getSKU();
			if (!empty($sku)) {
				$listingBean = BeanFactory::getBean('xeBayListings', $sku);
				if ($listingBean !== false)
				$orderTransaction->xinventory_id = $listingBean->xinventory_id;
			} else {
				$orderTransaction->xinventory_id = '';
			}
			$orderTransaction->orderline_item_id = $transaction->getOrderLineItemID();
			$orderTransaction->quantity_purchased = $transaction->getQuantityPurchased();
			$orderTransaction->transaction_id = $transaction->getTransactionID();
			$orderTransaction->sales_record_number = $transaction->getShippingDetails()->getSellingManagerSalesRecordNumber();
			$orderTransaction->price_currency_id = $transaction->getTransactionPrice()->getTypeAttribute('currencyID');
			$orderTransaction->price_value = $transaction->getTransactionPrice()->getTypeValue();

			$variation = $transaction->getVariation();
			if (!empty($variation) && is_array($variation)) {
				$sku = $variation->getSKU(); /* real sku */
				if (!empty($sku))
					$orderTransaction->xinventory_id = $sku;
				$orderTransaction->name = $variation->getVariationTitle();
				$orderTransaction->item_view_item_url = $variation->getVariationViewItemURL();
			}

			if (empty($duplicated)) {
				$orderTransaction->id = create_guid();
				$orderTransaction->new_with_id = true;
			}
			$orderTransaction->save();
		}
	}
}

?>
