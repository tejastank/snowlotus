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

require_once('include/ytree/Node.php');

//function returns an array of objects of Node type.
function get_node_data($params,$get_array=false) {
    $ret=array();
    $nodes = array();

    $click_level=$params['TREE']['depth'];
    $category_id=$params['NODES'][$click_level]['id'];
    $category_parent_id=$params['NODES'][$click_level-1]['id'];

    if (isset($category_id)) {
        $category_level=$click_level + 2;
        $where = "expired='0' AND category_level='$category_level'";
        $where .= " AND category_parent_id='$category_id'";
    } else {
        $category_level=$click_level + 1;
        $where = "expired=0 AND category_level=$category_level";
    }
    $bean = BeanFactory::getBean('xeBayCategories');
    $resp = $bean->get_list("name", $where, 0, -99, -99, 0, false, array('category_id', 'name', 'leaf_category'));
    foreach($resp['list'] as &$category) {
        $node = new Node($category->category_id, $category->name);
        if ($category->leaf_category == 1) {
            $node->dynamic_load = false;
        } else {
            $node->set_property("href", $href_string);
            $node->dynamic_load = true;
        }
        $nodes[] = $node;
    }

    if ($get_array)
        return $nodes;

	foreach ($nodes as $node) {
		$ret['nodes'][]=$node->get_definition();
	}
	$json = new JSON(JSON_LOOSE_TYPE);
	$str=$json->encode($ret);
	return $str;
}

?>
