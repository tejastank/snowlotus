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

/** Include PHPExcel */
require_once 'PHPExcel/Classes/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("xlongfeng")
							 ->setLastModifiedBy("xlongfeng")
							 ->setTitle("采购单")
							 ->setSubject("采购单")
							 ->setDescription("采购单")
							 ->setKeywords("采购单")
							 ->setCategory("采购单");

$objPHPExcel->createSheet();

$column_head_print = array(
	array(
		'name'=>'货位',
		'width'=>8,
	),
	array(
		'name'=>'名称',
		'width'=>48,
	),
	array(
		'name'=>'数量',
		'width'=>8,
	),
	array(
		'name'=>'价格',
		'width'=>8,
	),
	array(
		'name'=>'供应商',
		'width'=>64,
	)
);

$column_head_import = array(
	array(
		'name'=>'Subject',
		'width'=>64,
	),
	array(
		'name'=>'Price(RMB)',
		'width'=>16,
	),
	array(
		'name'=>'Quantity',
		'width'=>16,
	),
	array(
		'name'=>'Inventory',
		'width'=>36,
		'hidden'=>true,
	),
	array(
		'name'=>'Operation',
		'width'=>16,
		'hidden'=>true,
	),
);

set_column_head($objPHPExcel, 0, $column_head_print, '采购单');
set_column_head($objPHPExcel, 1, $column_head_import, '入库单');

$inventoryBean = BeanFactory::getBean('xInventories');
$recordBean = BeanFactory::getBean('xInventoryRecords');
$ebayTransactionBean = BeanFactory::getBean('xeBayTransactions');

$where = "strategy='listed'";
$resp = $inventoryBean->get_list("", $where, 0, -99, -99, 0, false, array('id', 'name', 'date_entered', 'quantity', 'price', 'goods_allocation'));
$nowTime = date('Y-m-d H:i:s', strtotime($GLOBALS['timedate']->nowDb()));
$startTime = date('Y-m-d H:i:s', strtotime($GLOBALS['timedate']->nowDb() . ' -15 days'));

echo "<pre>";

$row = 2;

foreach ($resp['list'] as &$item) {
    $where = "xinventory_id='{$item->id}' AND operation='out' AND date_entered>'{$startTime}'";
	$records = $recordBean->get_list("", $where, 0, -99, -99, 0, false, array('quantity'));

    $salesVolume = 0;
    $quantitys = array();
    foreach ($records['list'] as &$record) {
        $quantitys[] = $record->quantity;
    }

    $orderQuantity = count($quantitys);
    if ($orderQuantity > 15) {
        asort($quantitys, SORT_NUMERIC);
        for($i = 3; $i < $orderQuantity - 3; $i++)
            $salesVolume += $quantitys[$i];
        $salesVolume /= ($orderQuantity - 6);
        $salesVolume *= $orderQuantity; 
    } else {
        foreach($quantitys as &$value)
            $salesVolume += $value;
    }

	/* new product */
	$listedDays = (strtotime($nowTime) - strtotime($item->date_entered)) / (3600 * 24);
	echo "物品名称: {$item->name}, 上架天数: {$listedDays}\n";
	if ($listedDays  < 10) {
		$salesVolume *= 15;
		$salesVolume /= $listedDays;
	}

	$stockoutQuantity = 0;
	$where = "xinventory_id='{$item->id}' AND stockout='1'";
	$stockouts = $ebayTransactionBean->get_list("", $where, 0, -99, -99, 0, false, array('quantity_purchased'));
	foreach($stockouts as &$stockout) {
		$stockoutQuantity += $stockout->quantity_purchased;
	}

	$purchaseQuantity = 0;
	if ($item->quantity  > $salesVolume) {
		echo "物品名称: {$item->name}, 库存量 {$item->quantity}, 本月销量 {$salesVolume}, 库存充足!!!\n\n";
		continue;
	} else {
		$purchaseQuantity = $salesVolume - $item->quantity + $stockoutQuantity;
	}

	$purchaseQuantity = $purchaseQuantity - ($purchaseQuantity % 5) + 5;

    echo "物品名称: {$item->name}, 库存量: {$item->quantity}, 采购数量: {$purchaseQuantity}\n\n";

	$puchaseData = array();
	$importData = array();

	$puchaseData[] = $item->goods_allocation;
	$puchaseData[] = $item->name;
	$puchaseData[] = $purchaseQuantity;
	$puchaseData[] = $item->price;
	$item->load_relationship('xvendors');
	$vendors = $item->xvendors->getBeans();
	$address = '';
	foreach($vendors as &$vendor) {
		$phone = empty($vendor->phone_office) ? $vendor->phone_mobile : $vendor->phone_office;
		$address .= $vendor->billing_address_street ."({$phone})";
	}
	$puchaseData[] = $address;

	set_row_data($objPHPExcel, 0, $puchaseData, $row);

	$importData[] = $item->name;
	$importData[] = $item->price;
	$importData[] = $purchaseQuantity;
	$importData[] = $item->id;
	$importData[] = 'in';

	set_row_data($objPHPExcel, 1, $importData, $row);

	$row++;
}

echo "</pre>";

$objPHPExcel->setActiveSheetIndex(0);

date_default_timezone_set("Asia/Shanghai");
$filename = "采购单_" . date("Ymd");

ob_clean();
// sugar_cleanup(true); // todo

// Redirect output to a client’s web browser
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename={$filename}.xlsx");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

sugar_cleanup(true);

function set_column_head($excel, $index, $data, $title)
{
	$rowAlpha = 'A';
	$column = 0;
	foreach ($data as &$cell) {
	    $excel->setActiveSheetIndex($index)
	                ->setCellValueByColumnAndRow($column++, 1, $cell['name']);
		if (!empty($cell['width']))
    		$excel->setActiveSheetIndex($index)->getColumnDimension($rowAlpha)->setWidth($cell['width']);
		if (!empty($cell['hidden']))
    		$excel->setActiveSheetIndex($index)->getColumnDimension($rowAlpha)->setVisible(false);
		$rowAlpha++;
	}

	$excel->getActiveSheet()->setTitle($title);
	$excel->getActiveSheet()->setShowGridlines(true);
	$excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
	$excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
	$excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
	$excel->getActiveSheet()->getPageMargins()->setTop(0.2);
	$excel->getActiveSheet()->getPageMargins()->setRight(0.2);
	$excel->getActiveSheet()->getPageMargins()->setBottom(0.2);
	$excel->getActiveSheet()->getPageMargins()->setLeft(0.2);
}

function set_row_data($excel, $index, $data, $row)
{
	$column = 0;

    foreach ($data as &$cell) {
    	$excel->setActiveSheetIndex($index)
    	            ->setCellValueByColumnAndRow($column++, $row, $cell);
    }
}

?>
