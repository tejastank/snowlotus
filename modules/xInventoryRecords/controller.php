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

class xInventoryRecordsController extends SugarController
{
    var $pre_operation;
    var $pre_quantity;
    var $pre_xinventory_id;

    public function pre_save()
    {
        $this->pre_operation = $this->bean->operation;
        $this->pre_quantity = $this->bean->quantity;
        $this->pre_xinventory_id = $this->bean->xinventory_id;

        parent::pre_save();
    }

	public function action_save()
    {
        $item = BeanFactory::getBean('xInventories');

		if ($this->bean->new_with_id == true) {
            // new bean want to update xinventory must be implemented in xInventoryRecord bean class;
            // if ($item->retrieve($this->bean->xinventory_id) != null) {
                // if ($this->bean->operation == 'in') {
                    // $item->quantity += $this->bean->quantity;
                // } else {
                    // $quantity = $item->quantity;
                    // $quantity -= $this->bean->quantity;
                    // if ($quantity < 0) {
                        // $this->bean->quantity = $item->quantity;
                        // $item->quantity = 0;
                    // } else {
                        // $item->quantity = $quantity;
                    // }
                // }
                // $item->save();
            // }
        } else if (($this->pre_operation != $this->bean->operation)
                    || ($this->pre_quantity != $this->bean->quantity)
                    || ($this->pre_xinventory_id != $this->bean->xinventory_id)) {
            if ($this->pre_xinventory_id == $this->bean->xinventory_id) {
                if ($item->retrieve($this->bean->xinventory_id) != null) {
                    if ($this->pre_operation == $this->bean->operation) {
                        $diff = $this->bean->quantity - $this->pre_quantity;
                        if ($this->bean->operation == 'in') {
                            $item->quantity += $diff;
                        } else {
                            $item->quantity -= $diff;
                        }
                    } else { // operation changed
                        if ($this->pre_operation == 'in') {
                            $item->quantity -= $this->pre_quantity;
                            $item->quantity -= $this->bean->quantity;
                        } else {
                            $item->quantity += $this->pre_quantity;
                            $item->quantity += $this->bean->quantity;
                        }
                    }
                    if ($item->quantity < 0)
                        $item->quantity = 0;
                    $item->save();
                }
            } else { // xinventory id changed
                if ($item->retrieve($this->pre_xinventory_id) != null) {
                    if ($this->pre_operation == 'in') {
                        $item->quantity -= $this->pre_quantity;
                        if ($item->quantity < 0)
                            $item->quantity = 0;
                    } else {
                        $item->quantity += $this->pre_quantity;
                    }
                    $item->save();
                }

                if ($item->retrieve($this->bean->xinventory_id) != null) {
                    if ($this->bean->operation == 'in') {
                        $item->quantity += $this->bean->quantity;
                    } else {
                        $item->quantity -= $this->bean->quantity;
                        if ($item->quantity < 0)
                            $item->quantity = 0;
                    }
                    $item->save();
                }
            }
        }

        parent::action_save();
    }
}
?>
