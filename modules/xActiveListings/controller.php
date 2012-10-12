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
require_once('eBayApi/GetSellerList.php');

class xActiveListingsController extends SugarController
{
    function action_test()
    {
		echo "<h1>Test</h1>";
		$inventory = BeanFactory::getBean('xInventories');
		$skus = array(
			"DarkRed Bowknot Dust proof",
			"DarkRed Bowknot Dust proof nonexist",
			"Nokia Lumia 800 Yellow Mesh Case Cover",
			"SonyEricsson_MT27i_Mesh_Case_Cover_SkyBlue",
			"Apple iPhone4s Yellow Mesh Case Cover",
			"apple iphone4s Yellow Mesh Case Cover",
		);
		foreach ($skus as &$sku) {
			$len = strlen($sku);
			$inv = $inventory->retrieve_by_string_fields(array('sku' => $sku));
			if($inv != null) {
				echo "<h1>retrieve ($sku)<$len>, $inv->id ok </h1>";
			} else {
				echo "<h1>retrieve ($sku)<$len> failed </h1>";
			}
		}
    }

    function action_Import()
    {
		$GLOBALS['db']->query("DELETE FROM notes WHERE notes.parent_type = 'xActiveListings'");
		$GLOBALS['db']->query($GLOBALS['db']->truncateTableSQL('xactivelistings'));

		$endTimeFrom = date("c", time() + 3 * 24 * 60 * 60);
		$endTimeTo = date("c", time() + 60 * 24 * 60 * 60);
		$endTimeFrom = "2012-07-01T00:00:00";
		$endTimeTo = "2012-08-01T00:00:00";

		$sellerList = new GetSellerList;

		// $sellerList->dispatchCall(array(
			// 'EndTimeFrom' => $endTimeFrom,
			// 'EndTimeTo' => $endTimeTo,
		// ));

		$sellerList->getActiveListing(array(
			'EndTimeFrom' => $endTimeFrom,
			'EndTimeTo' => $endTimeTo,
		));

		$this->view = 'import';
    }

    function action_Update()
    {
		$bean = BeanFactory::getBean('xActiveListings');
		$inventory = BeanFactory::getBean('xInventories');
		$note = BeanFactory::getBean('Notes');

		$item_list = $bean->get_full_list();
		$this->view = 'update';
	}
}
?>