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
		$req->setOrderRole($params['OrderRole']);
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

		$bean = BeanFactory::getBean('xeBayOrders');
		$shipToAddress = BeanFactory::getBean('xeBayShipToAddresses');
		$transaction = BeanFactory::getBean('xeBayTransactions');

        $req = new GetOrdersRequestType();
        $req->setNumberOfDays($params['NumberOfDays']);
		$req->setOrderRole($params['OrderRole']);
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
					$addressId = $order->getShippingAddress()->getAddressID();
					if (empty($addressId))
						continue;
					$shipAddress = $shipToAddress->retrieve_by_string_fields(array('address_id'=>$addressId));
					if ($shipAddress === null) {
						$shippingAddress = $order->getShippingAddress();
						$shipToAddress->name = $shippingAddress->getName();
						$shipToAddress->street1 = $shippingAddress->getStreet1();
						$shipToAddress->street2 = $shippingAddress->getStreet2();
						$shipToAddress->city_name = $shippingAddress->getCityName();
						$shipToAddress->state_or_province = $shippingAddress->get();
						$shipToAddress->country = $shippingAddress->getCountry();
						$shipToAddress->country_name = $shippingAddress->getCountryName();
						$shipToAddress->phone = $shippingAddress->getPhone();
						$shipToAddress->postal_code = $shippingAddress->getPostalCode();
						$shipToAddress->address_id = $shippingAddress->getAddressID();
						$shipToAddress->address_owner = $shippingAddress->getAddressOwner();
						$shipToAddress->external_address_id = $shippingAddress->getExternalAddressID();
						$shipToAddress->id = create_guid();
						$shipToAddress->new_with_id = true;
						$shipToAddress->save();
					}

					$bean->buyer_checkout_message = $order->getBuyerCheckoutMessage();
					$bean->order_id = $order->getOrderID();
					$bean->order_status = $order->getOrderStatus();
					$bean->buyer_user_id = $order->getBuyerUserID();;
					$bean->subtotal_currency_id = $order->getSubtotal()->getCurrencyID();
					$bean->subtotal_value = $order->getSubtotal->getValue();;
					$bean->total_currency_id = $order->getTotal()->getCurrencyID();
					$bean->total_value = $order->getTotal()->getValue();;
					$bean->create_time = $order->getCreatedTime();;
					$bean->paid_time = $order->getPaidTime();;
					$bean->shipped_time = $order->getShippedTime();;
					$bean->ship_to_address_id = $shipToAddress->id;
					$bean->shipping_details_selling_manager_sales_record_number = $order->getShippingDetails()->getSellingManagerSalesRecordNumber();
					$bean->eias_token = $order->getEIASToken();
					$bean->payment_hold_status = $order->getPaymentHoldStatus();

					$transactionArray = $order->getTransactionArray();
					foreach ($transactionArray as &$transaction) {
						$transaction->order_id = $bean->id;
						$transaction->combine_order_id = $bean->id;
						$transaction->actual_handling_cost_currency_id = $transaction->getActualHandlingCost()->getCurrencyID();
						$transaction->actual_handling_cost_value = $transaction->getActualHandlingCost()->getValue();
						$transaction->actual_shipping_cost_currency_id = $transaction->getActualShippingCost()->getCurrencyID();
						$transaction->actual_shipping_cost_value = $transaction->getActualShippingCost()->getValue();
						$transaction->create_time = $transaction->getCreatedTime();
						$transaction->item_item_id = $transaction->getItem()->getItemID();
						$transaction->item_site = $transaction->getItem()->getSite();
						$transaction->item_sku = $transaction->getItem()->getSKU();
						$transaction->orderline_item_id = $transaction->getOrderLineItemID();
						$transaction->quantity_purchased = $transaction->getQuantityPurchased();
						$transaction->transaction_id = $transaction->getTransactionID();
						$transaction->shipping_details_selling_manager_sales_record_number = $transaction->getShippingDetails()->getSellingManagerSalesRecordNumber();
						$transaction->transaction_price_currency_id = $transaction->getTransactionPrice()->getCurrencyID();
						$transaction->transaction_price_value = $transaction->getTransactionPrice()->getValue();
						$transaction->variation_sku = '';
						$variation = $transaction->getVariation();
						if (!empty($variation)) {
							$transaction->variation_sku = $variation->getSKU();
						}

						$transaction->id = create_guid();
						$transaction->new_with_id = true;
						$transaction->save();
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
