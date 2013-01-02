<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

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

/*********************************************************************************

 * Description: Controller for the Import module
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 ********************************************************************************/

require_once("include/MVC/Controller/SugarController.php");
require_once('eBayApi/GetSessionID.php');
require_once('eBayApi/FetchToken.php');
require_once('eBayApi/GeteBayDetails.php');

class xeBayAccountsController extends SugarController
{
	public function pre_save()
	{
		if (!empty($_REQUEST['session_id'])) {
			$x = new FetchToken();
			$res = $x->dispatchCall(array('SessionID' => $_REQUEST['session_id']));
			if ($res !== false) {
				$this->bean->ebay_auth_token = $res['AuthToken'];
				$this->bean->hard_expiration_time = $res['ExpireTime'];
			} else {
				sugar_cleanup(true);
			}
		}

		parent::pre_save();
	}

    function action_connectnow()
    {
		$module = (!empty($this->return_module) ? $this->return_module : $this->module);
		$action = (!empty($this->return_action) ? $this->return_action : 'DetailView');

		$url = "index.php?module=".$module."&action=".$action;

		if(!empty($_REQUEST['record']))
			$url .= "&record=".$_REQUEST['record'];

		$x = new GetSessionID();
		$session_id = $x->dispatchCall(array());

		if ($session_id === false)
		{
			sugar_cleanup(true);
		}

		if (!empty($_REQUEST['name']))
			$url .= "&name=".$_REQUEST['name'];

		$url .= "&session_id=".$session_id;

		$this->set_redirect($url);
    }

	function action_getebaydetails()
	{
		$accounts = array();

		// for debug
		$_REQUEST['ebay_account_name'] = "xlongfeng";

		if (!empty($_REQUEST['ebay_account_name'])) {
			$name = $_REQUEST['ebay_account_name'];
			$bean = BeanFactory::getBean('xeBayAccounts');
			$accounts = $bean->get_accounts($name);
		}

		$x = new GeteBayDetails();

		// $x->dispatchCall(array('DetailName'=>'CountryDetails'));
		// exit;

		foreach ($accounts as $id => $authToken) {
			$result = $x->retrieveeBayDetails(array(
				'DetailName' => array(
					'BuyerRequirementDetails',
					'CountryDetails',
					'CurrencyDetails',
					'DispatchTimeMaxDetails',
					'ExcludeShippingLocationDetails',
					'ItemSpecificDetails',
					'ListingFeatureDetails',
					'ListingStartPriceDetails',
					'PaymentOptionDetails',
					'RecoupmentPolicyDetails',
					'RegionDetails',
					'RegionOfOriginDetails',
					'ReturnPolicyDetails',
					'ShippingCarrierDetails',
					'ShippingCategoryDetails',
					'ShippingLocationDetails',
					/* 'ShippingPackageDetails', */
					'ShippingServiceDetails',
					'SiteDetails',
					/* 'TaxJurisdiction', */
					/* 'TimeZoneDetails', */
					/* 'UnitOfMeasurementDetails', */
					'URLDetails',
					'VariationDetails',
				),
				'AccountID' => $id,
				'AuthToken' => $authToken,
			));
		}

		$this->redirect_url = "index.php?module=xeBayAccounts&action=DetailView&record={$this->record}";
	}
}
?>
