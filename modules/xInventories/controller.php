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

/*********************************************************************************

 * Description: Controller for the Import module
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 ********************************************************************************/

require_once("include/MVC/Controller/SugarController.php");

class xInventoriesController extends SugarController
{
    function action_purchase()
    {
		$bean = BeanFactory::getBean('xInventories');
		$recordBean = BeanFactory::getBean('xInventoryRecords');
        $resp = $bean->get_list("", "", 0, -1, -1, 0, false, array('id', 'name', 'quantity', 'inventory_floor', 'goods_allocation'));
        $startData = date('Y-m-d H:i:s', strtotime($GLOBALS['timedate']->nowDb() . ' -15 days'));
        echo "<pre>";
        echo "records start\n";
        foreach ($resp['list'] as &$item) {
            $where = "inventory_id='{$item->id}' AND operation='out' AND date_entered>'{$startData}' ";
			$records = $recordBean->get_list("", $where, 0, -1, -1, 0, false, array('quantity'));
            $quantity = 0;
            $quantitys = array();
            foreach ($records['list'] as &$record) {
                $quantitys[] = $record->quantity;
            }
            $orderQuantity = count($quantitys);
            if ($orderQuantity > 10) {
                asort($quantitys, SORT_NUMERIC);
                for($i = 3; $i < $orderQuantity - 3; $i++)
                    $quantity += $quantitys[$i];
                $quantity /= ($orderQuantity - 6);
                $quantity *= $orderQuantity; 
            } else {
                foreach($quantitys as &$value)
                    $quantity += $value;
            }
            print_r($quantitys);
            echo $item->name . "&nbsp;" . $item->quantity . "&nbsp;" . $quantity . "\n";
        }
        echo "records end\n";
        echo "</pre>";
        exit;
    }
}
?>
