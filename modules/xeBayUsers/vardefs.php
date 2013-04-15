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

$dictionary['xeBayUser'] = array(
	'table'=>'xebayusers',
	'audited'=>true,
	'duplicate_merge'=>true,
	'fields'=>array (
		// <AboutMeURL> anyURI </AboutMeURL>
		'aboutmeurl'=> array (
			'name' => 'aboutmeurl',
			'vname' => 'LBL_ABOUTMEURL',
			'type' => 'url',
			'len' => '255',
		),

		// <FeedbackDetailsURL> anyURI </FeedbackDetailsURL>
		// <FeedbackPrivate> boolean </FeedbackPrivate>
		// <FeedbackRatingStar> FeedbackRatingStarCodeType </FeedbackRatingStar>

		// <FeedbackScore> int </FeedbackScore>
		'feedbackscore' => array(
			'name' => 'feedbackscore',
			'vname' => 'LBL_FEEDBACKSCORE',
			'type' => 'int',
		),

		// <MyWorldLargeImage> anyURI </MyWorldLargeImage>
		// <MyWorldSmallImage> anyURI </MyWorldSmallImage>
		// <MyWorldURL> anyURI </MyWorldURL>
		// <NewUser> boolean </NewUser>

		// <RegistrationDate> dateTime </RegistrationDate>
		'registrationdate'=>
		array(
			'name'=>'registrationdate',
	    	'vname'=> 'LBL_REGISTRATIONDATE',
	    	'type'=>'datetime',
		),

		// <RegistrationSite> SiteCodeType </RegistrationSite>
		// <ReviewsAndGuidesURL> anyURI </ReviewsAndGuidesURL>
		// <SellerBusinessType> SellerBusinessCodeType </SellerBusinessType>

		// <SellerItemsURL> anyURI </SellerItemsURL>
		'selleritemsurl'=>
		array (
			'name' => 'selleritemsurl',
			'vname' => 'LBL_SELLERITEMSURL',
			'type' => 'url',
			'len' => '255',
		),

		// <SellerLevel> SellerLevelCodeType </SellerLevel>
		'sellerlevel' => array(
			'name' => 'sellerlevel',
			'vname' => 'LBL_SELLERLEVEL',
			'type' => 'varchar',
			'len' => '32',
		),

		'site' => array(
			'name' => 'site',
			'vname' => 'LBL_SITE',
			'type' => 'varchar',
			'len' => '32',
		),

		// <Status> UserStatusCodeType </Status>

		// <StoreName> string </StoreName>
		'storename' => array(
			'name' => 'storename',
			'vname' => 'LBL_STORENAME',
			'type' => 'varchar',
			'len' => '64',
		),

		// <StoreURL> anyURI </StoreURL>
		'storeurl'=>
		array (
			'name' => 'storeurl',
			'vname' => 'LBL_STOREURL',
			'type' => 'url',
			'len' => '255',
		),

		// <TopRatedSeller> boolean </TopRatedSeller>
		// <UserID> string </UserID>

		'xebaysellersurveys'=>
		array(
			'name'=>'xinventories',
			'vname'=>'LBL_SELLITEMS',
			'type'=>'link',
			'relationship' => 'xebaysellersurveys_xebayuser',
			'module'=>'xeBaySellerSurveys',
			'bean_name'=>'xebaysellersurvey',
			'source'=>'non-db',
		),
	),
	'relationships'=>array (
	),
	'optimistic_locking'=>true,
	'unified_search'=>true,
);

if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}

VardefManager::createVardef('xeBayUsers','xeBayUser', array('basic','assignable'));
