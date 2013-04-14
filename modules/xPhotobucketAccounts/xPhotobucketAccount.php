<?PHP
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

require_once 'PhotobucketApi/setincludepath.php';
require_once 'PBAPI.php';

class xPhotobucketAccount extends Basic {
	var $new_schema = true;
	var $module_dir = 'xPhotobucketAccounts';
	var $object_name = 'xPhotobucketAccount';
	var $table_name = 'xphotobucketaccounts';
	var $importable = true;
	var $disable_row_level_security = true ; // to ensure that modules created and deployed under CE will continue to function under team security if the instance is upgraded to PRO
	var $id;
	var $name;
	var $date_entered;
	var $date_modified;
	var $modified_user_id;
	var $modified_by_name;
	var $created_by;
	var $created_by_name;
	var $description;
	var $deleted;
	var $created_by_link;
	var $modified_user_link;
	var $assigned_user_id;
	var $assigned_user_name;
	var $assigned_user_link;

	var $auth_token;
	var $auth_token_secret;
	var $username;
	var $subdomain;

	var $oauth_token;
	var $oauth_token_secret;
	var $additional_column_fields = Array('oauth_token', 'oauth_token_secret');

    /**
     * Consumer Key (aka scid or developer key)
     * Fill in with your own
     */
    private static $consumer_key = 149833735;
    /**
     * Consumer Secret (aka private key)
     * Fill in with your own
     */
    private static $consumer_secret = '9583020d7838b0a56c161fa65800e1c0';

    /**
     * API object
     */
    private $api;

	function xPhotobucketAccount()
	{
        $this->api = new PBAPI(self::$consumer_key, self::$consumer_secret);
        $this->api->setResponseParser('phpserialize');

		parent::Basic();
	}
	
	function bean_implements($interface)
	{
		switch ($interface) {
			case 'ACL': return true;
		}
		return false;
	}

    function retrieve($id = -1, $encode=true,$deleted=true)
    {
		$res = parent::retrieve($id, $encode, $deleted);

		if (!empty($res)) {
			if (!empty($this->auth_token) && !empty($this->auth_token_secret)) {
				$this->api->setOAuthToken($this->auth_token, $this->auth_token_secret, $this->username);
				$this->api->setSubdomain($this->subdomain);
			}
		}

		return $res;
	}

	function fill_in_additional_detail_fields()
	{
		if (!empty($_REQUEST['name']))
			$this->name = $_REQUEST['name'];

		if (!empty($_REQUEST['oauth_token']) && !empty($_REQUEST['oauth_token_secret'])) {
            $this->oauth_token = $_REQUEST['oauth_token'];
            $this->oauth_token_secret= $_REQUEST['oauth_token_secret'];
            $this->api->setOAuthToken($_REQUEST['oauth_token'], $_REQUEST['oauth_token_secret']);
        }

		parent::fill_in_additional_detail_fields();
	}

    function get_request_token()
    {
        $this->api->login('request')->post()->loadTokenFromResponse();
        return $this->api->getOAuthToken();
    }

    function get_sign_in_url()
    {
        return $this->api->getLoginURL();
    }

    function set_access_token()
    {
		if (!empty($_REQUEST['oauth_token']) && !empty($_REQUEST['oauth_token_secret'])) {
            $this->api->setOAuthToken($_REQUEST['oauth_token'], $_REQUEST['oauth_token_secret']);
            $this->api->login('access')->post()->loadTokenFromResponse();
            $token = $this->api->getOAuthToken();
            $this->auth_token = $token->getKey();
            $this->auth_token_secret = $token->getSecret();
            $this->username = $this->api->getUsername();
            $this->subdomain = $this->api->getSubdomain();
        }
    }

	function upload_media($type, $uploadfile, $filename = null, $title = null)
	{
		$params = array(
			'type' => $type,
			'uploadfile' => $uploadfile,
		);

		if (!empty($filename))
			$params['filename'] = $filename;

		if (!empty($title))
			$params['title'] = $title;

		// return $this->api->album($this->username, array('media' => 'images'))->get()->getParsedResponse(true);
		// return $this->api->album($this->username)->upload($params)->post()->getResponseString();
		try {
			return $this->api->album($this->username)->upload($params)->post()->getParsedResponse(true);
		} catch (PBAPI_Exception_Response $e) {
			echo "RESPONSE $e";
		} catch (PBAPI_Exception $e) {
			echo "EX $e";
		}
		sugar_cleanup(true);
	}

	function delete_media($url)
	{
		$resp = null;
		try {
			$resp = $this->api->media($url)->delete()->getParsedResponse(true);
			return $resp;
		} catch (PBAPI_Exception_Response $e) {
			echo "<pre>";
			echo "RESPONSE $e";
		} catch (PBAPI_Exception $e) {
			echo "<pre>";
			echo "EX $e";
			sugar_cleanup(true);
		}
	}
}
?>
