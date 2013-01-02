<?php
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

$dictionary['xeBayListing'] = array(
	'table'=>'xebaylistings',
	'audited'=>true,
	'duplicate_merge'=>true,
	'fields'=>array (
		'applicationdata' => array(
			'name' => 'applicationdata',
			'vname' => 'LBL_APPLICATIONDATA',
			'type' => 'varchar',
			'len' => '32',
			'comment' => 'Returns custom, application-specific data associated with the item.',
		),
		'autopay' => array(
			'name' => 'autopay',
			'vname' => 'LBL_AUTOPAY',
			'type' => 'bool',
			'default' => false,
		),
		'bestofferenabled' => array(
			'name' => 'bestofferenabled',
			'vname' => 'LBL_BESTOFFERENABLED',
			'type' => 'bool',
			'default' => false,
		),
		'conditiondescription' => array(
			'name' => 'conditiondescription',
			'vname' => 'LBL_CONDITIONDESCRIPTION',
			'type' => 'varchar',
			'len' => '1000',
		),
		'conditionid' => array(
			'name' => 'conditionid',
			'vname' => 'LBL_CONDITIONID',
			'type' => 'int',
			'required' => true,
		),
		'country' => array(
			'name' => 'country',
			'vname' => 'LBL_COUNTRY',
			'type' => 'varchar',
			'len' => '2',
		),
		'crossbordertrade' => array(
			'name' => 'crossbordertrade',
			'vname' => 'LBL_CROSSBORDERTRADE',
			'type' => 'varchar',
			'len' => '32',
			'comment' => 'This field is used by sellers who want their listing to be returned in the search results for other eBay sites.',
		),
		'currency' => array(
			'name' => 'currency',
			'vname' => 'LBL_CURRENCY',
			'type' => 'varchar',
			'len' => '3',
		),
		'description' => array(
			'name' => 'description',
			'vname' => 'LBL_DESCRIPTION',
			'type' => 'html',
		),
		'disablebuyerrequirements' => array(
			'name' => 'disablebuyerrequirements',
			'vname' => 'LBL_DISABLEBUYERREQUIREMENTS',
			'type' => 'bool',
			'default' => false,
			'comment' => 'If true: all buyer requirements (from Item.BuyerRequirementDetails or Buyer requirements preferences in My eBay) are ignored.',
		),
		// DiscountPriceInfo
		'dispatchtimemax' => array(
			'name' => 'dispatchtimemax',
			'vname' => 'LBL_DISPATCHTIMEMAX',
			'type' => 'int',
		),
		// GetItFast
		'hitcounter' => array(
			'name' => 'hitcounter',
			'vname' => 'LBL_HITCOUNTER',
			'type' => 'varchar',
			'len' => '32',
		),
		// InventoryTrackingMethod, only available in AddFixedPirceItem
		// ItemCompatibilityList
		// ItemSpecifics
		// ListingCheckoutRedirectPreference
		// ListingDesigner
		// ListingDetails
		'listingduration' => array(
			'name' => 'listingduration',
			'vname' => 'LBL_LISTINGDURATION',
			'type' => 'varchar',
			'len' => '16',
			'comment' => 'The valid choice of values depends on the listing format (see Item.ListingType). For a list of valid values, call GetCategoryFeatures with DetailLevel set to ReturnAll and look for ListingDurations information.',
		),
		// ListingEnhancement
		'listingtype' => array(
			'name' => 'listingtype',
			'vname' => 'LBL_LISTINGTYPE',
			'type' => 'varchar',
			'len' => '32',
		),
		'location' => array(
			'name' => 'location',
			'vname' => 'LBL_LOCATION',
			'type' => 'varchar',
			'len' => '45',
			'default' => 'Shenzhen',
		),
		'paymentmethods' => array(
			'name' => 'paymentmethods',
			'vname' => 'LBL_PAYMENTMETHODS',
			'type' => 'text',
			'default' => "<?xml version='1.0' standalone='yes'?><PaymentMethods></PaymentMethods>",
		),
		'paypalemailaddress' => array(
			'name' => 'paypalemailaddress',
			'vname' => 'LBL_PAYPALEMAILADDRESS',
			'type' => 'varchar',
			'len' => '32',
		),
		'picturedetails' => array(
			'name' => 'picturedetails',
			'vname' => 'LBL_PICTUREDETAILS',
			'type' => 'text',
			'default' => "<?xml version='1.0' standalone='yes'?><PictureDetails></PictureDetails>",
		),
		'postalcode' => array(
			'name' => 'postalcode',
			'vname' => 'LBL_POSTALCODE',
			'type' => 'varchar',
			'len' => '32',
			'default' => '518000',
		),
		'primarycategoryid' => array(
			'name' => 'primarycategoryid',
			'vname' => 'LBL_PRIMARYCATEGORYID',
			'type' => 'varchar',
			'len' => '10',
			'required' => true,
		),
		// ProductListingDetails
		'quantity' => array(
			'name' => 'quantity',
			'vname' => 'LBL_QUANTITY',
			'type' => 'int',
			'required' => true,
		),
		// QuantityInfo
		// QuantityRestrictionPerBuyer
		'returnpolicy' => array(
			'name' => 'returnpolicy',
			'vname' => 'LBL_RETURNPOLICY',
			'type' => 'text',
			'default' => "<?xml version='1.0' standalone='yes'?><ReturnPolicy></ReturnPolicy>",
		),
		'scheduletime'=>
		array(
			'name'=>'scheduletime',
	    	'vname'=> 'LBL_SCHEDULETIME',
	    	'type'=>'datetime',
		),
		'secondarycategoryid' => array(
			'name' => 'secondarycategoryid',
			'vname' => 'LBL_SECONDARYCATEGORYID',
			'type' => 'varchar',
			'len' => '10',
		),
		'shippingdetails' => array(
			'name' => 'shippingdetails',
			'vname' => 'LBL_SHIPPINGDETAILS',
			'type' => 'text',
			'default' => "<?xml version='1.0' standalone='yes'?><ShippingDetails></ShippingDetails>",
			'comment' => 'ExcludeShipToLocation, InternationalShippingServiceOption, PaymentInstructions, ShippingServiceOptions, ShippingType:Flat',
		),
		// ShippingPackageDetails
		// ShippingTermsInDescription
		'shiptolocations' => array(
			'name' => 'shiptolocations',
			'vname' => 'LBL_SHIPTOLOCATIONS',
			'type' => 'text',
			'default' => "<?xml version='1.0' standalone='yes'?><ShipToLocations></ShipToLocations>",
		),
		'site' => array(
			'name' => 'site',
			'vname' => 'LBL_SITE',
			'type' => 'varchar',
			'len' => '32',
		),
		'sku' => array(
			'name' => 'sku',
			'vname' => 'LBL_SKU',
			'type' => 'id',
			'required' => true,
		),
		'startprice'=>
		array(
			'name'=>'startprice',
	    	'vname'=> 'LBL_STARTPRICE',
	    	'type'=>'double',
		),
		'storecategory2id' => array(
			'name' => 'storecategory2id',
			'vname' => 'LBL_STORECATEGORY2ID',
			'type' => 'long',
			'commnet' => 'Unique identifier for a second custom category that the seller created in their eBay Store',
		),
		'storecategoryid' => array(
			'name' => 'storecategoryid',
			'vname' => 'LBL_STORECATEGORYID',
			'type' => 'long',
			'commnet' => 'Unique identifier for a custom category that the seller created in their eBay Store',
		),
		'subtitle' => array(
			'name' => 'subtitle',
			'vname' => 'LBL_SUBTITLE',
			'type' => 'varchar',
			'len' => '55',
		),
		'name' => array(
			'name' => 'name',
			'vname' => 'LBL_NAME',
			'type' => 'varchar',
			'len' => '80',
			'required' => true,
		),
		'uuid' => array(
			'name' => 'uuid',
			'vname' => 'LBL_UUID',
			'type' => 'varchar',
			'len' => '32',
			'required' => true,
		),
		// Variations, Only available in AddFixedPriceItem
		'variations' => array(
			'name' => 'variations',
			'vname' => 'LBL_VARIATIONS',
			'type' => 'text',
			'default' => "<?xml version='1.0' standalone='yes'?><Variations></Variations>",
		),
		'short_title' => array(
			'name' => 'short_title',
			'vname' => 'LBL_SHORT_TITLE',
			'type' => 'varchar',
			'len' => '55',
		),
		'primarycategory_name'=>
		array(
			'name'=>'primarycategory_name',
			'rname' => 'name',
			'vname'=>'LBL_PRIMARYCATEGORY',
			'id_name'=>'primarycategoryid',
			'type'=>'relate',
			'link'=>'primarycategory_link',
			'reportable'=>false,
			'source'=>'non-db',
			'dbType' => 'varchar',
			'table' => 'xebaycategories',
			'module' => 'xeBayCategories',
			'required' => true,
		),
		'primarycategory_link'=>
		array(
			'name' => 'primarycategory_link',
			'type' => 'link',
			'relationship' => 'xebaylisting_primarycategory',
			'vname' => 'LBL_PRIMARYCATEGORY',
			'source'=>'non-db',
		),
		'secondarycategory_name'=>
		array(
			'name'=>'secondarycategory_name',
			'rname' => 'name',
			'vname'=>'LBL_SECONDARYCATEGORY',
			'id_name'=>'secondarycategoryid',
			'type'=>'relate',
			'link'=>'secondarycategory_link',
			'reportable'=>false,
			'source'=>'non-db',
			'dbType' => 'varchar',
			'table' => 'xebaycategories',
			'module' => 'xeBayCategories',
		),
		'secondarycategory_link'=>
		array(
			'name' => 'secondarycategory_link',
			'type' => 'link',
			'relationship' => 'xebaylisting_secondarycategory',
			'vname' => 'LBL_SECONDARYCATEGORY',
			'source'=>'non-db',
		),
		'inventory_name'=>
		array(
			'name'=>'inventory_name',
			'rname' => 'name',
			'vname'=>'LBL_INVENTORY',
			'id_name'=>'sku',
			'type'=>'relate',
			'link'=>'inventory_link',
			'reportable'=>false,
			'source'=>'non-db',
			'dbType' => 'varchar',
			'table' => 'xinventories',
			'module' => 'xInventories',
			'required' => true,
		),
		'inventory_link'=>
		array(
			'name' => 'inventory_link',
			'type' => 'link',
			'relationship' => 'xebaylisting_inventory',
			'vname' => 'LBL_INVENTORY',
			'source'=>'non-db',
		),
	),
	'relationships'=>array (
		'xebaylisting_primarycategory' => array(
			'lhs_module'=> 'xeBayCategories', 'lhs_table'=> 'xebaycategories', 'lhs_key' => 'id',
			'rhs_module' => 'xeBayListings', 'rhs_table'=> 'xebaylistings', 'rhs_key' => 'primarycategoryid',
			'relationship_type'=>'one-to-many'),
		'xebaylisting_secondarycategory' => array(
			'lhs_module'=> 'xeBayCategories', 'lhs_table'=> 'xebaycategories', 'lhs_key' => 'id',
			'rhs_module' => 'xeBayListings', 'rhs_table'=> 'xebaylistings', 'rhs_key' => 'secondarycategoryid',
			'relationship_type'=>'one-to-many'),
		'xebaylisting_inventory' => array(
			'lhs_module'=> 'xInventories', 'lhs_table'=> 'xinventories', 'lhs_key' => 'id',
			'rhs_module' => 'xeBayListings', 'rhs_table'=> 'xebaylistings', 'rhs_key' => 'sku',
			'relationship_type'=>'one-to-many'),
	),
	'optimistic_locking'=>true,
	'unified_search'=>true,
);

if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}

VardefManager::createVardef('xeBayListings','xeBayListing', array('basic','assignable'));
