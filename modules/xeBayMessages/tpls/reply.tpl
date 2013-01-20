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




*}
<form name="xeBayMessageReply" id="xeBayMessageReply" enctype='multipart/form-data' method="POST" action="index.php">
<input type='hidden' name='action' value='reply'/>
<input type='hidden' name='module' value='xeBayMessages'/>
<input type='hidden' name='record' value='{$RECORD}'/>
<span class='error'>{$error.main}</span>
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="actionsContainer">
<tr>
	<td>
		<input title="{$MOD.LBL_EMAIL_REPLY}" accessKey="" class="button primary" id="xeBayMessageReply_reply_button" type="submit" name="reply" value="{$APP.LBL_EMAIL_REPLY}">
		<span class="id-ff multiple">
		<button title="{$MOD.LBL_SELECT_BUTTON_TITLE}" type="button" tabindex='0' class="button firstChild" value='{$APP.LBL_SELECT_BUTTON_LABEL}' name="btn_author"  id="btn_author"
						onclick='open_popup("xeBayMessageTemplates", 600, 400, "", true, false, {$ENCODED_TEMPLATES_POPUP_REQUEST_DATA});'>{$TEMPLATE_SELECT}</button>
{if 0}
		<button type="button" name="btn_clr" id="btn_clr" tabindex="0" title="{$APP.LBL_CLEAR_BUTTON_TITLE}" class="button lastChild"
						onclick="this.form.response.value = ''; " value="{$APP.LBL_CLEAR_BUTTON_LABEL}" >{$TEMPLATE_CLEAR}</button>
{/if}
		</span>
	</td>
</tr>
</table>

<table  width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
	<tr>
		<td scope="row"><span style="font-weight:bold">{$MOD.LBL_NAME}:</span>&nbsp;&nbsp;<input title="" id="subject" name="subject" type="text" size="78" value="{$SUBJECT}"></td>
	</tr>
	<tr>
		<td scope="row" colspan="2" style="font-weight:bold">{$SALUTATION}</td>
	</tr>
	<tr>
		<td scope="row" colspan="2"><textarea id='response' name='response' rows="10" cols="120" title='' tabindex="" accesskey=''>{$RESPONSE}</textarea></td>
	</tr>
	<tr>
		<td scope="row" colspan="2" style="font-weight:bold">{$SIGNATURE}</td>
	</tr>
</table>

{$JAVASCRIPT}

</form>
{literal}
<script type='text/javascript'>
YAHOO.util.Event.onDOMReady(function(){
});
</script>
{/literal}
