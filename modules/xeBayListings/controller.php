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

class xeBayListingsController extends SugarController
{
	function action_preview()
	{
		echo $this->bean->description_html();
		sugar_cleanup(true);
	}
	
	function action_exportrss()
	{
		//Bug 30094, If zlib is enabled, it can break the calls to header() due to output buffering. This will only work php5.2+
		ini_set('zlib.output_compression', 'Off');
		date_default_timezone_set("Asia/Shanghai");
		$filename = "kittenrss_" . date("YmdHis");
		
		ob_start();
		
		$bean = BeanFactory::getBean('xeBayListings');
		//$item_list = $bean->get_full_list("", "(listing_type='Chinese' OR listing_type='FixedPriceItem')");
		$item_list = $bean->get_full_list();
		if (count($item_list) == 0) {
			echo "Export RSS failed: No item";
			ob_end_flush();
			sugar_cleanup(true);
		}
		
		$tmpfname = tempnam(sys_get_temp_dir(), "kitten");
		
		$zip = new ZipArchive;
		
		$res = $zip->open($tmpfname, ZipArchive::CREATE);
		if ($res === TRUE) {
			foreach ($item_list as &$item) {
				// if (empty($item->item_id))
					//continue;
				$rss = $item->build_shopwindow_topmost(true);
				if (!empty($rss))
					$zip->addFromString("rss/{$item->id}/head.xml", $rss);
		
				$rss = $item->build_shopwindow_correlation(true);
				if (!empty($rss))
					$zip->addFromString("rss/{$item->id}/correlation.xml", $rss);
		
				$rss = $item->build_shopwindow_random(true);
				if (!empty($rss))
					$zip->addFromString("rss/{$item->id}/random.xml", $rss);
			}
		
			$zip->close();
			$zipContent = file_get_contents($tmpfname);
			unlink($tmpfname);
			ob_clean();
			header("Pragma: cache");
			header('Content-Type: application/octet-stream');
			header("Content-Disposition: attachment; filename={$filename}.zip");
			header("Content-transfer-encoding: binary");
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
			header("Last-Modified: " . TimeDate::httpTime() );
			header("Cache-Control: post-check=0, pre-check=0", false );
			header("Content-Length: " . strlen($zipContent));
			print $zipContent;
		} else {
			echo 'Export RSS failed: Open zip file';
			ob_end_flush();
		}
		sugar_cleanup(true);
	}
}
?>
