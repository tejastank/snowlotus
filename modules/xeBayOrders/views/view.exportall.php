<?php
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

require_once('include/MVC/View/SugarView.php');
require_once 'PHPExcel/Classes/PHPExcel.php';

class xeBayOrdersViewExportAll extends SugarView {

	function xeBayOrdersViewExportAll()
    {
 		parent::SugarView();
	}
	
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

	function default_export($orders)
	{
	}
	
	function _4px_export($orders)
	{
        ini_set('zlib.output_compression', 'Off');
        ob_start();
 
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("xlongfeng")
        							 ->setLastModifiedBy("xlongfeng")
        							 ->setTitle("订单批量导入")
        							 ->setSubject("订单批量导入")
        							 ->setDescription("订单批量导入")
        							 ->setKeywords("订单批量导入")
        							 ->setCategory("订单批量导入");
        
        $column_head_import = array(
        	'客户单号',
        	'服务商单号',
        	'运输方式',
        	'目的国家',
        	'寄件人公司名',
        	'寄件人姓名',
        	'寄件人地址',
        	'寄件人电话',
        	'寄件人邮编',
        	'寄件人传真',
        	'收件人公司名',
        	'收件人姓名',
        	'州 \ 省',
        	'城市',
        	'联系地址',
        	'收件人电话',
        	'收件人邮箱',
        	'收件人邮编',
			'收件人传真',
			'买家ID',
			'交易ID',
			'保险类型',
			'保险价值',
			'订单备注',
			'重量',
			'是否退件',
			'海关报关品名1','配货信息1','申报价值1','申报品数量1','配货备注1',
			'海关报关品名2','配货信息2','申报价值2','申报品数量2','配货备注2',
			'海关报关品名3','配货信息3','申报价值3','申报品数量3','配货备注3',
			'海关报关品名4','配货信息4','申报价值4','申报品数量4','配货备注4',
			'海关报关品名5','配货信息5','申报价值5','申报品数量5','配货备注5',
        );
        
        $this->set_column_head($objPHPExcel, 0, $column_head_import, 'ebay批量上传模版');

        $row = 2;
        
        foreach ($orders as &$order) {
			$orderLine['客户单号'] = "{$order['type']}{$order['sales_record_number']}";
			$orderLine['服务商单号'] = '';
        	$orderLine['运输方式'] = map4pxShippingService($order['shipping_service']);
			$orderLine['目的国家'] = $order['country'];
			$orderLine['寄件人公司名'] = '';
        	$orderLine['寄件人姓名'] = '';
        	$orderLine['寄件人地址'] = '';
        	$orderLine['寄件人电话'] = '';
        	$orderLine['寄件人邮编'] = '';
        	$orderLine['寄件人传真'] = '';
        	$orderLine['收件人公司名'] = '';
        	$orderLine['收件人姓名'] = $order['name'];
			$orderLine['州 \ 省'] = $order['state'];
			$orderLine['城市'] = $order['city'];
			$orderLine['联系地址'] = "{$order['street1']}";
			if (!empty($order['street2']))
				$orderLine['联系地址'] .= " {$order['street2']}";
        	$orderLine['收件人电话'] = $order['phone'];
        	$orderLine['收件人邮箱'] = '';
			$orderLine['收件人邮编'] = $order['postal_code'];
			$orderLine['收件人传真'] = '';
			$orderLine['买家ID'] = $order['buyer_user_id'];
			$orderLine['交易ID'] = '';
			$orderLine['保险类型'] = '';
			$orderLine['保险价值'] = '';
			$orderLine['订单备注'] = '';
			$orderLine['重量'] = $order['total_weight'];
			$orderLine['是否退件'] = '';
			
			for ($i = 1; $i < 6; $i++) {
				$orderLine["海关报关品名{$i}"] = "";
				$orderLine["配货信息{$i}"] = "";
				$orderLine["申报价值{$i}"] = "";
				$orderLine["申报品数量{$i}"] = "";
				$orderLine["配货备注{$i}"] = "";
            }
			
			$index = 1;
			$isfive = false;
			if (count($order['order_details']) == 5)
				$isfive = true;
            foreach($order['order_details'] as &$detail) {
				if ($index < 5) {
					$orderLine["海关报关品名{$index}"] = "{$detail['declaration_name']} ({$detail['quantity']}";
					$orderLine["配货信息{$index}"] = "{$detail['location']} {$detail['inventory_name']}";
					$orderLine["申报价值{$index}"] = $detail['value'];
					$orderLine["申报品数量{$index}"] = $detail['quantity'];
					$orderLine["配货备注{$index}"] = "";
					$index++;
				} else {
					if (!empty($orderLine["配货信息5"])) {
						$orderLine["配货信息5"] .= '<br>';
					} else {
						$orderLine["海关报关品名5"] = "{$detail['declaration_name']} ({$detail['quantity']}";
						$orderLine["配货信息5"] = '';
						$orderLine["申报价值5"] = $detail['value'];
						$orderLine["申报品数量5"] = 0;
						$orderLine["配货备注5"] = "";
					}
					$orderLine["配货信息5"] .= "{$detail['location']} {$detail['inventory_name']} * {$detail['quantity']})";
					$orderLine["申报品数量5"] += $detail['quantity'];
				}
            }
        
        	$this->set_row_data($objPHPExcel, 0, $orderLine, $row);
        
        	$row++;
        }

        $objPHPExcel->setActiveSheetIndex(0);
        
        date_default_timezone_set("Asia/Shanghai");
        $filename = "4px_递四方速递_" . date("Ymd");

        // Redirect output to a client’s web browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename={$filename}.xls");
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
	}

	function sfc_export($orders)
	{
        ini_set('zlib.output_compression', 'Off');
        ob_start();
 
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("xlongfeng")
        							 ->setLastModifiedBy("xlongfeng")
        							 ->setTitle("订单批量导入")
        							 ->setSubject("订单批量导入")
        							 ->setDescription("订单批量导入")
        							 ->setKeywords("订单批量导入")
        							 ->setCategory("订单批量导入");
        
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
        
        $this->set_column_head($objPHPExcel, 0, $column_head_import, 'ebay批量上传模版');

        $row = 2;
        
        foreach ($orders as &$order) {
        	$orderLine['declared value'] = "{$order['total_currency']} {$order['total_value']}";
        	$orderLine['evaluate'] = "{$order['total_currency']} {$order['total_value']}";
        	$orderLine['is return'] = 'Y';
        	$orderLine['with_battery'] = 'N';
        	$orderLine['weight'] = $order['total_weight'];
        	$orderLine['Length'] = '';
        	$orderLine['Width'] = '';
        	$orderLine['Height'] = '';
        	$orderLine['Sales Record Number'] = $order['sales_record_number'];
        	$orderLine['User Id'] = $order['buyer_user_id'];
        	$orderLine['Buyer Fullname'] = $order['name'];
        	$orderLine['Buyer Phone Number'] = $order['phone'];
        	$orderLine['Buyer Email'] = '';
        	$orderLine['Buyer Address 1'] = $order['street1'];
        	$orderLine['Buyer Address 2'] = $order['street2'];
        	$orderLine['Buyer City'] = $order['city'];
        	$orderLine['Buyer State'] = $order['state'];
        	$orderLine['Buyer Zip'] = $order['postal_code'];
        	$orderLine['Buyer Country'] = $order['country'];
            $item_title = '';
            $custom_label = '';
            foreach($order['order_details'] as &$detail) {
                if (!empty($item_title))
                    $item_title .= '<br>';
                $item_title .= "{$detail['location']} {$detail['declaration_name']} x{$detail['quantity']}) ";
                if (!empty($custom_label))
                    $custom_label .= '<br>';
                $custom_label .= "{$detail['location']} {$detail['inventory_name']} x{$detail['quantity']}) ";
            }
        	$orderLine['Item Title'] = $item_title;
        	$orderLine['Custom Label'] = $custom_label;
        	$orderLine['Quantity'] = $order['quantity'];
        	$orderLine['Sale Price'] = "{$order['subtotal_currency']} {$order['subtotal_value']}";
        	$orderLine['Total Price'] = "{$order['total_currency']} {$order['total_value']}";
        	$orderLine['Shipping Service'] = $order['shipping_service'];
        
        	$this->set_row_data($objPHPExcel, 0, $orderLine, $row);
        
        	$row++;
        }

        $objPHPExcel->setActiveSheetIndex(0);
        
        date_default_timezone_set("Asia/Shanghai");
        $filename = "sfc_三态速递_" . date("Ymd");

        // Redirect output to a client’s web browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename={$filename}.xls");
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
	}

	function pfc_export($orders)
	{
        ini_set('zlib.output_compression', 'Off');
        ob_start();
 
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("xlongfeng")
        							 ->setLastModifiedBy("xlongfeng")
        							 ->setTitle("订单批量导入")
        							 ->setSubject("订单批量导入")
        							 ->setDescription("订单批量导入")
        							 ->setKeywords("订单批量导入")
        							 ->setCategory("订单批量导入");

        $column_head_import = array(
			'客户参考编号',
			'运输方式',
			'投保易网邮保险服务',
			'Buyer Fullname',
			'Buyer Phone Number',
			'Buyer Email',
			'Buyer Address 1',
			'Buyer Address 2',
			'Buyer City',
			'Buyer State',
			'Buyer Zip',
			'Buyer Country',
			'物品类别内容1',
			'总重量(千克)',
			'货币',
			'总值',
			'物品1', '数量1', '净重1', '货币1', '价值1',
			'物品2', '数量2', '净重2', '货币2', '价值2',
			'物品3', '数量3', '净重3', '货币3', '价值3',
			'物品4', '数量4', '净重4', '货币4', '价值4',
			'物品5', '数量5', '净重5', '货币5', '价值5',
		);

        $this->set_column_head($objPHPExcel, 0, $column_head_import, 'ebay批量上传模版');

        $row = 2;

        foreach ($orders as &$order) {
			$orderLine = array();
        	$orderLine['客户参考编号'] = $order['sales_record_number'];
        	$orderLine['运输方式'] = mapPfcShippingService($order['shipping_service']);
        	$orderLine['投保易网邮保险服务'] = 'N';
        	$orderLine['Buyer Fullname'] = $order['name'];
        	$orderLine['Buyer Phone Number'] = $order['phone'];
        	$orderLine['Buyer Email'] = '';
        	$orderLine['Buyer Address 1'] = $order['street1'];
        	$orderLine['Buyer Address 2'] = $order['street2'];
        	$orderLine['Buyer City'] = $order['city'];
        	$orderLine['Buyer State'] = $order['state'];
        	$orderLine['Buyer Zip'] = $order['postal_code'];
        	$orderLine['Buyer Country'] = $order['country'];
        	$orderLine['物品类别内容1'] = 'W';
        	$orderLine['总重量(千克)'] = $order['total_weight'];
        	$orderLine['货币'] = $order['total_currency'];
        	$orderLine['总值'] = $order['total_value'];
			$index = 1;
			$isfive = false;
			if (count($order['order_details']) == 5)
				$isfive = true;
            foreach($order['order_details'] as &$detail) {
				if ($index < 5) {
					$orderLine["物品{$index}"] = "{$detail['location']} {$detail['inventory_name']}";
					$orderLine["数量{$index}"] = $detail['quantity'];
					$orderLine["净重{$index}"] = $detail['weight'];
					$orderLine["货币{$index}"] = $detail['currency'];
					$orderLine["价值{$index}"] = $detail['value'];
					$index++;
				} else {
					if (!empty($orderLine["物品5"])) {
						$orderLine["物品5"] .= '<br>';
					} else {
						$orderLine["物品5"] = '';
						$orderLine["数量5"] = 0;
						$orderLine["货币5"] = $detail['currency'];
					}
					if ($isfive)
						$orderLine["物品5"] .= "{$detail['location']} {$detail['inventory_name']}";
					else
						$orderLine["物品5"] .= "{$detail['location']} {$detail['inventory_name']} x{$detail['quantity']})";
					$orderLine["数量5"] += $detail['quantity'];
					$orderLine["净重5"] += $detail['weight'];
					$orderLine["价值5"] += $detail['value'];
				}
            }

        	$this->set_row_data($objPHPExcel, 0, $orderLine, $row);
        
        	$row++;
        }

        $objPHPExcel->setActiveSheetIndex(0);
        
        date_default_timezone_set("Asia/Shanghai");
        $filename = "pfc_皇家物流_" . date("Ymd");

        // Redirect output to a client’s web browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename={$filename}.xls");
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
	}

    function process()
    {
		$stockout_checked = $_REQUEST['stockout_checked'];
		$automerge = $_REQUEST['automerge'];
		$printed_order_included = $_REQUEST['printed_order_included'];
		$express_carrier = $_REQUEST['express_carrier'];

		$bean = BeanFactory::getBean('xeBayOrders');
        $orders = $bean->get_valid_orders(array(), $stockout_check, $automerge, $printed_order_included);

		$export = "{$express_carrier}_export";
		$this->$export($orders);

		$this->display();
	}
	
	function display()
	{
		// header("Location: index.php?module=xeBayOrders&action=index&filter=unhandled");
	}
}

?>
