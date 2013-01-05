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


class xeBayListingsViewEdit extends ViewEdit {

 	function xeBayListingsViewEdit(){
 		parent::ViewEdit();
 	}
 	
 	function display() {
		global $mod_strings;

        $description = $this->bean->description;
        $description = <<<EOQ
<div id='description_text_div'>
    <textarea id='description_text' tabindex='0' name='description' cols="100" rows="40">{$description}</textarea>
</div>
EOQ;
		$this->ev->ss->assign("CUSTOM_DISCRIPTION", $description);

 		parent::display();

        require_once("include/SugarTinyMCE.php");
        $tiny = new SugarTinyMCE();
        $tiny->defaultConfig['cleanup_on_startup']=true;
        $tiny->defaultConfig['width']=800;
        $tiny->defaultConfig['height']=600;
        $tiny->defaultConfig['plugins'].=",fullpage";
        echo $tiny->getInstance();

        $javascript = <<<EOQ
<script type="text/javascript" language="Javascript">
setTimeout("tinyMCE.execCommand('mceAddControl', false, 'description_text');", 500);
var tiny = tinyMCE.getInstanceById('description_text');
document.getElementById('description_text_div').style.display = 'inline';
</script>
EOQ;
        echo $javascript;
 	}
}
?>
