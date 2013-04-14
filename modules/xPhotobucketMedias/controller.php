<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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

/*
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 require_once('include/MVC/Controller/SugarController.php');
  
  
class xPhotobucketMediasController extends SugarController
{
	public function pre_save()
	{
		require_once('include/upload_file.php');
		$upload_file = new UploadFile('filename_file');
		if (isset($_FILES['filename_file']) && $upload_file->confirm_upload()) {
    		$filename = $upload_file->get_stored_file_name();
			$file_ext = $upload_file->file_ext;
        	if (empty($this->bean->id)) {
        	    $this->bean->id = create_guid();
        	    $this->bean->new_with_id = true;
			}
			$account = null;
			if(isset($_POST['xphotobucketaccount_id'])) {
				$account = BeanFactory::getBean('xPhotobucketAccounts', $_POST['xphotobucketaccount_id']);
			}
			// $resp = $account->upload_media('image', $upload_file->temp_file_location, "{$this->bean->id}.{$file_ext}", $_POST['name']);
			$resp = $account->upload_media('base64', base64_encode(file_get_contents($upload_file->temp_file_location)), "{$this->bean->id}.{$file_ext}", $_POST['name']);
			$this->bean->browse_url = $resp['browseurl'];
			$this->bean->image_url = $resp['url'];
			$this->bean->thumb_url = $resp['thumb'];
		} else {
			echo "Upload file error";
			sugar_cleanup(true);
		}

		parent::pre_save();
	}
}
?>
