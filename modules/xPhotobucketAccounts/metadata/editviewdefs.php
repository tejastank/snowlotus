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

$viewdefs['xPhotobucketAccounts']['EditView'] = array(
	'templateMeta' => array(
		'form' => array(
			'hidden' => array(
				'<input type="hidden" name="oauth_token" id="oauth_token" value="{if isset($smarty.request.oauth_token)}{$smarty.request.oauth_token}{else}{$bean->oauth_token}{/if}">',
				'<input type="hidden" name="oauth_token_secret" id="oauth_token_secret" value="{if isset($smarty.request.oauth_token_secret)}{$smarty.request.oauth_token_secret}{else}{$bean->oauth_token_secret}{/if}">',
			),
			'buttons' => array('SAVE', 'CANCEL',
				array (
					'customCode' => '<input title="{$MOD.LBL_LOGIN}" id="login" accessKey="" class="button primary" onclick="return photobucket_login()" type="button" name="button" value="{$MOD.LBL_LOGIN}">',
				),
			),
		),
		'maxColumns' => '2', 
		'widths' => array(
						array('label' => '10', 'field' => '30'), 
						array('label' => '10', 'field' => '30')
					),                                                                                                                                    
	),
 
	'panels' => array (
		'default' => array (
			array (
				'name',
				'assigned_user_name',
			),
			array (
				'description',
			),
		),
	),
);
?>
