<?php
/**
 * sources
 */
require_once 'eBayApiEnvironment.php';
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
class GetOrders extends eBayApiEnvironment
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
		$result = true;
		$account_id = $params['AccountID'];
		$this->session->setRequestToken($params['AuthToken']);

		$bean = BeanFactory::getBean('xeBayOrders');
		$orderTransaction = BeanFactory::getBean('xeBayTransactions');

        $req = new GetOrdersRequestType();
        $req->setNumberOfDays($params['NumberOfDays']);
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
					$oldOrder = $bean->retrieve_by_string_fields(array('order_id'=>$orderId));
					if (!empty($oldOrder)) {
						$checkoutStatusLastModifiedTime = $order->getCheckoutStatus()->getLastModifiedTime();
						if ($oldOrder->checkout_status_last_modified_time != $checkoutStatusLastModifiedTime) {
							$oldOrder->checkout_status_last_modified_time = $order->getCheckoutStatus()->getLastModifiedTime();
							$oldOrder->shipped_time = $order->getShippedTime();
							if (!empty($oldOrder->shipped_time))
								$oldOrder->handled_status = 'handled';
							$oldOrder->save();
						}
						continue;
					}

					$bean->handled_status = 'unhandled';
					$bean->ebay_account_id = $account_id;
					$bean->buyer_checkout_message = $order->getBuyerCheckoutMessage();
					$bean->order_id = $order->getOrderID();
					$bean->checkout_status_last_modified_time = $order->getCheckoutStatus()->getLastModifiedTime();
					$bean->order_status = $order->getOrderStatus();
					$bean->buyer_user_id = $order->getBuyerUserID();
					$bean->subtotal_currency_id = $order->getSubtotal()->getTypeAttribute('currencyID');
					$bean->subtotal_value = $order->getSubtotal()->getTypeValue();
					$bean->total_currency_id = $order->getTotal()->getTypeAttribute('currencyID');
					$bean->total_value = $order->getTotal()->getTypeValue();
					$bean->date_entered = $order->getCreatedTime();
					$bean->paid_time = $order->getPaidTime();
					$bean->shipped_time = $order->getShippedTime();
					if (!empty($bean->shipped_time))
						$bean->handled_status = 'handled';
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

					$bean->id = create_guid();
					$bean->new_with_id = true;
					$bean->save();

					$transactionArray = $order->getTransactionArray();
					foreach ($transactionArray as &$transaction) {
						$orderTransaction->order_id = $bean->id;
						$orderTransaction->combine_order_id = $bean->id;
						$orderTransaction->actual_handling_cost_currency_id = $transaction->getActualHandlingCost()->getTypeAttribute('currencyID');
						$orderTransaction->actual_handling_cost_value = $transaction->getActualHandlingCost()->getTypeValue();
						$orderTransaction->actual_shipping_cost_currency_id = $transaction->getActualShippingCost()->getTypeAttribute('currencyID');
						$orderTransaction->actual_shipping_cost_value = $transaction->getActualShippingCost()->getTypeValue();
						$orderTransaction->date_entered = $transaction->getCreatedDate();
						$orderTransaction->item_item_id = $transaction->getItem()->getItemID();
						$orderTransaction->item_site = $transaction->getItem()->getSite();
						$orderTransaction->name =  $transaction->getItem()->getTitle();
						$orderTransaction->item_view_item_url = 'http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=' . $orderTransaction->item_item_id;
						$orderTransaction->item_sku = $transaction->getItem()->getSKU();
						$orderTransaction->orderline_item_id = $transaction->getOrderLineItemID();
						$orderTransaction->quantity_purchased = $transaction->getQuantityPurchased();
						$orderTransaction->transaction_id = $transaction->getTransactionID();
						$orderTransaction->sales_record_number = $transaction->getShippingDetails()->getSellingManagerSalesRecordNumber();
						$orderTransaction->price_currency_id = $transaction->getTransactionPrice()->getTypeAttribute('currencyID');
						$orderTransaction->price_value = $transaction->getTransactionPrice()->getTypeValue();

						$variation = $transaction->getVariation();
						if (!empty($variation) && is_array($variation)) {
							$orderTransaction->item_sku = $variation->getSKU();
							$orderTransaction->name = $variation->getVariationTitle();
							$orderTransaction->item_view_item_url = $variation->getVariationViewItemURL();
						}

						$orderTransaction->id = create_guid();
						$orderTransaction->new_with_id = true;
						$orderTransaction->save();
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
}

?>
