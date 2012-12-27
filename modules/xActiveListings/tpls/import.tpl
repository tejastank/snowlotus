{*
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

*}

{$INSTRUCTION}

<div class="hr"><hr /></div>

<form enctype="multipart/form-data" name="import" method="POST" action="index.php" id="import">
<input type="hidden" name="module" value="xActiveListings">
<input type="hidden" name="action" value="ImportFinal">
<table width="100%" style="border:2px solid #4e8ccf;margin-top:10px;" cellspacing="10" cellpadding="0">
	<tr>
		<td width="50%" align="right">
			{$MOD.LBL_EBAY_ACCOUNT}
		</td>
		<td width="50%" align="left">
			{$EBAY_ACCOUNT_OPTIONS}
		</td>
	</tr>
	<tr>
		<td align="right">
			{$MOD.LBL_NUMBER_OF_DAYS}
		</td>
		<td align="left">
			<select name='time_left' id='time_left' title=''>
				<option value='1'>1</option>
				<option value='3'>3</option>
				<option value='5'>5</option>
				<option value='7'>7</option>
				<option value='15'>15</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right">
		</td>
		<td align="left">
			<input title="{$MOD.LBL_IMPORT}"  class="button" type="submit" name="button" value="  {$MOD.LBL_IMPORT}  " id="import" onclick="return ImportConfirm()">
		</td>
	</tr>
</table>

<script>
{$JAVASCRIPT}
</script>  
</form>
