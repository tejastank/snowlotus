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

<div class="clear"></div>

<h1>hello world</h1>

<div style='float:left; width: 50%;'>
{foreach name=tabs from=$tabs key=k item=tab}
	<input type="button" class="button" {if $view == $tab} selected {/if} id="{$tabs_params[$tab].id}" title="{$tabs_params[$tab].title}" value="{$tabs_params[$tab].title}" onclick="{$tabs_params[$tab].link}">
{/foreach}
</div>

<input class="date_input" autocomplete="off" type="text" name="goto_date" id="goto_date" value="{$current_date}" title='' size="11" maxlength="10" >
<img border="0" src="{$cal_img}" alt="{$APP.LBL_ENTER_DATE}" id="goto_date_trigger" align="absmiddle">

<script type="text/javascript">
Calendar.setup ({ldelim}
inputField : "goto_date",
ifFormat : "%m/%d/%Y",
daFormat : "%m/%d/%Y",
button : "goto_date_trigger",
singleClick : true,
dateStr : "{$current_date}",
startWeekday: {$start_weekday},
step : 1,
weekNumbers:false
{rdelim}
);
</script>

<div style='clear: both;'></div>
