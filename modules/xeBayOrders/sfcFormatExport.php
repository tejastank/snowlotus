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
							 ->setTitle("三态订单批量导入")
							 ->setSubject("三态订单批量导入")
							 ->setDescription("三态订单批量导入")
							 ->setKeywords("三态订单批量导入")
							 ->setCategory("三态订单批量导入");

$column_head_import = array(
	'declared value',
	'evaluate',
	'is return',
	'with_battery',
	'weight',
	'Length',
	'Width',
	'Height',
	'Sales Record Number',
	'User Id',
	'Buyer Fullname',
	'Buyer Phone Number',
	'Buyer Email',
	'Buyer Address 1',
	'Buyer Address 2',
	'Buyer City',
	'Buyer State',
	'Buyer Zip',
	'Buyer Country',
	'Item Title',
	'Custom Label',
	'Quantity',
	'Sale Price',
	'Total Price',
	'Shipping Service',
);

set_column_head($objPHPExcel, 0, $column_head_import, 'ebay批量上传模版');

$ebayOrderBean = BeanFactory::getBean('xeBayOrders');

$where = "handled_status='unhandled'";
$list = $ebayOrderBean->get_full_list("", $where);

if ($list === null) {
	ob_clean();
	sugar_cleanup(true);
}

$row = 2;

foreach ($list as &$order) {
	$order->load_relationship('xebaytransactions');
	$transactions = $order->xebaytransactions->getBeans();
    $quantity = 0; 
    $weight = 0;
    foreach($transactions as &$transaction) {
        $quantity += $transaction->quantity_purchased;
        $weight += ($transaction->weight * $quantity);
    }

	$orderLine['declared value'] = "{$order->total_currency_id} {$order->total_value}";
	$orderLine['evaluate'] = "{$order->total_currency_id} {$order->total_value}";
	$orderLine['is return'] = 'Y';
	$orderLine['with_battery'] = 'N';
	$orderLine['weight'] = $weight;
	$orderLine['Length'] = '';
	$orderLine['Width'] = '';
	$orderLine['Height'] = '';
	$orderLine['Sales Record Number'] = $order->sales_record_number;
	$orderLine['User Id'] = $order->buyer_user_id;
	$orderLine['Buyer Fullname'] = $order->name;
	$orderLine['Buyer Phone Number'] = $order->phone;
	$orderLine['Buyer Email'] = '';
	$orderLine['Buyer Address 1'] = $order->street1;
	$orderLine['Buyer Address 2'] = $order->street2;
	$orderLine['Buyer City'] = $order->city_name;
	$orderLine['Buyer State'] = $order->state_or_province;
	$orderLine['Buyer Zip'] = $order->postal_code;
	$orderLine['Buyer Country'] = $order->country;
	$orderLine['Item Title'] = '';
	$orderLine['Custom Label'] = '';
	$orderLine['Quantity'] = $quantity;
	$orderLine['Sale Price'] = "{$order->total_currency_id} {$order->total_value}";
	$orderLine['Total Price'] = "{$order->total_currency_id} {$order->total_value}";
	$orderLine['Shipping Service'] = $order->shipping_service;

	set_row_data($objPHPExcel, 0, $orderLine, $row);

	$row++;
}

$objPHPExcel->setActiveSheetIndex(0);

date_default_timezone_set("Asia/Shanghai");
$filename = "三态速递订单_" . date("Ymd");

ob_clean();

// Redirect output to a client’s web browser
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename={$filename}.xls");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->setOffice2003Compatibility(true);
$objWriter->save('php://output');

sugar_cleanup(true);

function set_column_head($excel, $index, $data, $title)
{
	$row = 1;
	$column = 'A';
	foreach ($data as &$cell) {
		if (is_array($cell)) {
	    	$excel->setActiveSheetIndex($index)
	    	            ->setCellValue($column.$row, $cell['name']);
			if (!empty($cell['width']))
    			$excel->setActiveSheetIndex($index)->getColumnDimension($column)->setWidth($cell['width']);
			if (!empty($cell['hidden']))
    			$excel->setActiveSheetIndex($index)->getColumnDimension($column)->setVisible(false);
		} else {
	    	$excel->setActiveSheetIndex($index)
	    	            ->setCellValue($column.$row, $cell);
		}
        $excel->setActiveSheetIndex($index)->getColumnDimension($column)->setAutoSize(true);
		$column++;
	}

	$excel->getActiveSheet()->setTitle($title);
}

function set_row_data($excel, $index, $data, $row)
{
    $column = 'A';

    foreach ($data as &$cell) {
        if (is_array($cell)) {
    	    $excel->setActiveSheetIndex($index)
    	                ->setCellValue($column.$row, $cell['value']);
            if (!empty($cell['autosize'])) {
                $excel->setActiveSheetIndex($index)->getStyle($column.$row)->getAlignment()->setWrapText(true);
                $excel->setActiveSheetIndex($index)->getRowDimension($row)->setRowHeight(-1);
            }
        } else {
    	    $excel->setActiveSheetIndex($index)
    	                ->setCellValue($column.$row, $cell);
        }
        $column++;
    }
}

?>
