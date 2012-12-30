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


/**
 * xActiveListingsViewImport.php
 * 
 * This class overrides SugarView and provides an implementation for the ValidPortalUsername
 * method used for checking whether or not an existing portal user_name has already been assigned.
 * We take advantage of the MVC framework to provide this action which is invoked from
 * a javascript AJAX request.
 * 
 * @author xlongfeng
 * */
 
require_once('include/MVC/View/SugarView.php');
require_once('include/ytree/Tree.php');
require_once('include/ytree/Node.php');
require_once('modules/xeBayCategories/TreeData.php');

class xeBayCategoriesViewBrowser extends SugarView 
{
    public function get_test_nodes($href_string)
    {
        $nodes = array();

        $cat_node = new Node("1111", "1111");
        $cat_node->set_property("href", $href_string);
        // $cat_node->expanded = false;
        $cat_node->dynamic_load = false;
        $subcat_node = new Node("sub 1111", "sub 1111");
        $cat_node->add_node($subcat_node);
        $nodes[] = $cat_node;

        $cat_node = new Node("2222", "2222");
        $cat_node->set_property("href", $href_string);
        $cat_node->dynamic_load = false;
        $nodes[] = $cat_node;

        $cat_node = new Node("3333", "3333");
        $cat_node->set_property("href", $href_string);
        $cat_node->dynamic_load = false;
        $nodes[] = $cat_node;

        $cat_node = new Node("4444", "4444");
        $cat_node->set_property("href", $href_string);
        $cat_node->dynamic_load = true;
        $nodes[] = $cat_node;

        return $nodes;
    }

 	/**
     * @see SugarView::display()
     */
    public function display()
    {
        global $mod_strings;
		$ss = new Sugar_Smarty();
        $ss->assign("MOD", $GLOBALS['mod_strings']);
        $ss->assign("INSTRUCTION", "<h1>{$mod_strings['LNK_BROWSER']}</h1>");

        //tree header.
        $doctree=new Tree('doctree');
        $doctree->tree_style = 'include/ytree/TreeView/css/default/tree.css';
        $doctree->set_param('module','xeBayCategories');
 
        $nodes = get_node_data(
            array(
                'TREE' => array('depth'=>0),
                // 'NODES' => array(array('id'=>1)),
            ), 
            true);
        // $nodes = get_category_nodes($href_string);
        // $nodes = $this->get_test_nodes($href_string);
        foreach ($nodes as $node) {
            $doctree->add_node($node);       
        }
        $ss->assign("TREEHEADER", $doctree->generate_header());
        $ss->assign("TREEINSTANCE", $doctree->generate_nodes_array());

        $site_data = "<script> var site_url= {\"site_url\":\"".getJavascriptSiteURL()."\"};</script>\n";
        $ss->assign("SITEURL",$site_data);

      	$javascript = <<<EOQ
EOQ;
      	$ss->assign("JAVASCRIPT", $javascript);

		echo $ss->fetch("modules/xeBayCategories/tpls/browser.tpl");
 	}
}
