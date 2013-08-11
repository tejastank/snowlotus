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

//Bug 30094, If zlib is enabled, it can break the calls to header() due to output buffering. This will only work php5.2+
ini_set('zlib.output_compression', 'Off');
ini_set("auto_detect_line_endings", true);

date_default_timezone_set("Asia/Shanghai");
$filename = "kitten_file_exchange_format_" . date("YmdHis");

ob_start();

$tmpfname = tempnam(sys_get_temp_dir(), "kitten");
$handle = fopen($tmpfname, "w");

if ($handle === false) {
	echo 'Export File Exchange Format: Open file';
	ob_end_flush();
	sugar_cleanup(true);
}

fputcsv($handle, file_exchange_format_header());

if (isset($_REQUEST['uid'])) {
	$ids = explode(',', $_REQUEST['uid']);
	$bean = BeanFactory::getBean('xeBayListings');
	foreach ($ids as &$id) {
		if ($bean->retrieve($id) !== null) {
			$line = file_exchange_format();
			$line['Title'] = $bean->name;
			$line['Custom Label'] = $bean->id;
			$line['Description'] = $bean->description_html();
			fputcsv($handle, $line);
		}
	}
}

fclose($handle);
$csv = file_get_contents($tmpfname);
$strips = array(
	"\n" => "\r\n",
);
$csv = strtr($csv, $strips);
unlink($tmpfname);

header("Pragma: cache");
header('Content-Type: application/octet-stream');
header("Content-Disposition: attachment; filename={$filename}.csv");
header("Content-transfer-encoding: binary");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . TimeDate::httpTime() );
header("Cache-Control: post-check=0, pre-check=0", false );
header("Content-Length: " . strlen($csv));
print $csv;
sugar_cleanup(true);

function file_exchange_format()
{
	return array(
		'Action(CC=Cp1252)' => 'Add',
		'SiteID' => 'US',
		'Format' => 'Auction',
		'Title' => '',
		'Condition' => '1000',
		'Custom Label' => '',
		'Category' => '20349',
		'Quantity' => '1',
		'Currency' => 'USD',
		'StartPrice' => '3.99',
		'BuyItNowPrice' => '9.99',
		'Duration' => '7',
		'Country' => 'CN',
		'Description' => '',
		'HitCounter' => 'HiddenStyle',
		'GalleryType' => 'Gallery',
		'Location' => 'ShenZhen',
		'ImmediatePayRequired' => '1',
		'PayPalAccepted' => '1',
		'PayPalEmailAddress' => 'xlongfeng@hotmail.com',
		'PaymentInstructions' => 'None Specified',
		'ShippingType' => 'Flat',
		'GlobalShippingService' => '0',
		'ShippingPackage' => 'Letter',
		'MeasurementUnit' => 'English',
		'ShippingService-1:Option' => 'EconomyShippingFromOutsideUS',
		'ShippingService-1:Cost' => '0',
		'ShippingService-1:Priority' => '1',
		'ShippingService-1:FreeShipping' => '1',
		'GetItFast' => '0',
		'DispatchTimeMax' => '1',
		'IntlShippingService-1:Option' => 'StandardInternational',
		'IntlShippingService-1:Cost' => '0',
		'IntlShippingService-1:Locations' => 'Worldwide',
		'IntlShippingService-1:Priority' => '1',
		'IntlAddnlShiptoLocations' => 'Worldwide',
		'BuyerRequirements:MinFeedbackScore' => '-1',
		'BuyerRequirements:MaxUnpaidItemsCount' => '2',
		'BuyerRequirements:MaxUnpaidItemsPeriod' => 'Days_30',
		'BuyerRequirements:MaxItemCount' => '1',
		'BuyerRequirements:MaxItemMinFeedback' => '',
		'BuyerRequirements:LinkedPayPalAccount' => '1',
		'BuyerRequirements:VerifiedUser' => '',
		'BuyerRequirements:VerifiedUserScore' => '',
		'BuyerRequirements:MaxViolationCount' => '4',
		'BuyerRequirements:MaxViolationPeriod' => 'Days_30',
		'ListingDesigner:LayoutID' => '10000',
		'ListingDesigner:ThemeID' => '10',
		'ShippingDiscountProfileID' => '0||',
		'InternationalShippingDiscountProfileID' => '0||',
		'Apply Profile Domestic' => '0',
		'Apply Profile International' => '0',
		'PromoteCBT' => '',
		'ShipToLocations' => 'Worldwide',
		'ReturnsAcceptedOption' => 'ReturnsAccepted',
		'ReturnsWithinOption' => 'Days_30',
		'RefundOption' => 'MoneyBack',
		'ShippingCostPaidBy' => 'Buyer',
	);
}

function file_exchange_format_header()
{
	return array_keys(file_exchange_format());
}