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

<form enctype="multipart/form-data" name="import" method="POST" action="index.php" id="import">
<input type="hidden" name="module" value="xeBayCategories">
<input type="hidden" name="action" value="index">
<table width="100%" style="border:2px solid #4e8ccf;margin-top:10px;" cellspacing="10" cellpadding="0">
</table>

<!-- BEGIN: TreeView -->
{$SITEURL}
{$TREEHEADER}
{$SET_RETURN_JS}

<script>
{literal}
function select_document(treeid) {
	var node=YAHOO.namespace(treeid).selectednode;
	send_back('Documents',node.data.id);
}

function populate_parent_search(treeid) {
	var node=YAHOO.namespace(treeid).selectednode;
		
	if (node.depth==1) {
		new_subcategory_id=node.data.id;
		if (new_subcategory_id == 'null') new_subcategory_id='';
		new_category_id=node.parent.data.id;
		if (new_category_id == 'null') new_category_id='';
	} else {
		new_category_id=node.data.id;
		if (new_category_id == 'null') new_category_id='';
		new_subcategory_id='';	
	}

	if(!window.opener.document.getElementById('Documentsadvanced_searchSearchForm')) {
		window.opener.location = 'index.php?searchFormTab=advanced_search&module=Documents&action=index&query=true&category_id_advanced' +'='+escape(new_category_id)+'&subcategory_id_advanced='+escape(new_subcategory_id);
	} else {
		var searchTab = (window.opener.document.getElementById('Documentsadvanced_searchSearchForm').style.display == '') ? 'advanced' : 'basic';
		window.opener.location = 'index.php?searchFormTab='+searchTab+'_search&module=Documents&acti8n=index&query=true&category_id_'+searchTab+'='+escape(new_category_id)+'&subcategory_id_'+searchTab+'='+escape(new_subcategory_id);
	}
	window.close();
}

function populate_search(treeid) {
	var node=YAHOO.namespace(treeid).selectednode;

	if (node.depth==1) {
		new_subcategory_id=node.data.id;
		if (new_subcategory_id == 'null') new_subcategory_id='';
		new_category_id=node.parent.data.id;
		if (new_category_id == 'null') new_category_id='';
	} else {
		new_category_id=node.data.id;
		if (new_category_id == 'null') new_category_id='';
		new_subcategory_id='';	
	}


	document.popup_query_form.subcategory_id.value=new_subcategory_id;
	document.popup_query_form.category_id.value=new_category_id;
	
	document.popup_query_form.submit();
}
{/literal}
</script>

<table cellpadding="0" cellspacing="0" style="border-left:1px solid; border-right:1px solid; border-bottom:1px solid" width="100%" class="edit view">
<tr>
	<td width="100%" valign="top" style="border-right: 1px">
		<div id="doctree">
			{$TREEINSTANCE}
		</div>
	</td>
</tr>
</table>

<script>
{$JAVASCRIPT}
</script>  
</form>
