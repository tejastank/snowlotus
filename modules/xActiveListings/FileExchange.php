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

//Bug 30094, If zlib is enabled, it can break the calls to header() due to output buffering. This will only work php5.2+
ini_set('zlib.output_compression', 'Off');

ob_start();

date_default_timezone_set("Asia/Shanghai");
$filename = "FileExchange_" . date("YmdHis");

$format = array("auction" => false, "fixedprice" => false);
$scope = array("description" => false, "sku" => false);

if (!empty($_REQUEST['auction']))
   $format['auction'] = true;
if (!empty($_REQUEST['fixedprice']))
   $format['fixedprice'] = true;

if (!empty($_REQUEST['description']))
   $scope['description'] = true;
if (!empty($_REQUEST['sku']))
   $scope['sku'] = true;

$column_head = array('auction', 'itemId');

if ($scope['description'])
   $column_head[] = 'description';

if ($scope['sku'])
   $column_head[] = 'sku';

$bean = BeanFactory::getBean('xActiveListings');
$inventory = BeanFactory::getBean('xInventories');
$note = BeanFactory::getBean('Notes');

$item_list = $bean->get_full_list();

/** Include PHPExcel */
require_once 'PHPExcel/Classes/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("xlongfeng")
							 ->setLastModifiedBy("xlongfeng")
							 ->setTitle("eBay File exchange")
							 ->setSubject("eBay File exchange")
							 ->setDescription("eBay File exchange")
							 ->setKeywords("eBay File exchange")
							 ->setCategory("eBay");

$column = 0;
foreach ($column_head as &$title) {
   $objPHPExcel->setActiveSheetIndex(0)
               ->setCellValueByColumnAndRow($column++, 1, $title);
}

$row = 2;
foreach ($item_list as &$item) {
   switch ($item->listing_type) {
   case 'Chinese':
      if (!$format['auction'])
         continue;
   case 'FixedPriceItem':
      if (!$format['fixedprice'])
         continue;
   default:
         continue;
   }
   $metadatas = array("revised", $item->item_id);
   if ($scope['description'])
      $metadatas[] = $item->name;
   if ($scope['sku'])
      $metadatas[] = $item->sku;

   $column = 0;
   foreach ($metadatas as &$data) {
   $objPHPExcel->setActiveSheetIndex(0)
               ->setCellValueByColumnAndRow($column++, $row, $data);
   }
   $row++;
}

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('FileExchange');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

ob_clean();

// Redirect output to a client’s web browser (CSV)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename={$filename}.csv");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
$objWriter->save('php://output');

sugar_cleanup(true);
?>
