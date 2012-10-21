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


/**
 * xActiveListingsViewUpdate.php
 * 
 * This class overrides SugarView and provides an implementation for the ValidPortalUsername
 * method used for checking whether or not an existing portal user_name has already been assigned.
 * We take advantage of the MVC framework to provide this action which is invoked from
 * a javascript AJAX request.
 * 
 * @author xlongfeng
 * */
 
require_once('include/MVC/View/SugarView.php');

class xActiveListingsViewUpdate extends SugarView 
{
 	/**
     * @see SugarView::display()
     */
    public function display()
    {
        global $mod_strings, $app_list_strings, $app_strings;

		$ss = new Sugar_Smarty();
		$ss->assign("MOD", $GLOBALS['mod_strings']);
		$ss->assign("INSTRUCTION", "<h1>Revise ebay listings</h1>");
      // $ss->assign("FILE_EXCHANGE_URL", "<a href=\"javascript: void(0);\" onclick=\"window.location.href='index.php?entryPoint=FileExchange&module=xActiveListings&action=index&all=true'\" >".$mod_strings['LBL_DOWNLOAD_FILE_EXCHANGE']."</a>");
		$ss->assign("FILE_EXCHANGE_URL", "<a href=\"javascript: void(0);\" onclick=FileExchange()>".$mod_strings['LBL_DOWNLOAD_FILE_EXCHANGE']."</a>");
      $javascript = <<<EOQ
function FileExchange()
{
   var href="index.php?entryPoint=FileExchange&module=xActiveListings&action=index&all=true";
   var format=document.getElementsByName("format[]");
   var scope=document.getElementsByName("scope[]");
   var format_flag=false;
   var scope_flag=false;
   for (var i=0;i<format.length;i++)
   {
      if(format[i].checked==true)
      {
         if (format[i].value=="auction")
         {
            format_flag = true;
            href = href.concat("&auction=true");
         }
         if (format[i].value=="fixedprice")
         {
            format_flag = true;
            href = href.concat("&fixedprice=true");
         }
      }
   }
   for (var i=0;i<scope.length;i++)
   {
      if(scope[i].checked==true)
      {
         if (scope[i].value=="description")
         {
            scope_flag = true;
            href = href.concat("&description=true");
         }
         if (scope[i].value=="sku")
         {
            scope_flag = true;
            href = href.concat("&sku=true");
         }
      }
   }
   if ((format_flag==false)||(scope_flag==false))
   {
      alert("You must check correct options!");
      return;
   }
   window.location.href=href;
}

function ReviseConfirm()
{
   var format=document.getElementsByName("format[]");
   var scope=document.getElementsByName("scope[]");
   var format_flag=false;
   var scope_flag=false;
   for (var i=0;i<format.length;i++)
   {
      if(format[i].checked==true)
      {
         if (format[i].value=="auction")
         {
            format_flag = true;
         }
         if (format[i].value=="fixedprice")
         {
            format_flag = true;
         }
      }
   }
   for (var i=0;i<scope.length;i++)
   {
      if(scope[i].checked==true)
      {
         if (scope[i].value=="description")
         {
            scope_flag = true;
         }
         if (scope[i].value=="sku")
         {
            scope_flag = true;
         }
      }
   }
   if ((format_flag==false)||(scope_flag==false))
   {
      alert("You must check correct options!");
      return false;
   }
   return confirm("Do you want to revise active listings now ?");
}
EOQ;
      $ss->assign("JAVASCRIPT", $javascript);
		echo $ss->fetch("modules/xActiveListings/tpls/update.tpl");
 	}
}
