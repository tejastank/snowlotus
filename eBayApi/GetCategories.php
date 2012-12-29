<?php
/**
 * sources
 */
require_once 'eBayApiEnvironment.php';
require_once 'GetCategoriesRequestType.php';

/**
 * sample_GetCategories
 * 
 * Sample call for GetCategories
 * 
 * @package ebatns
 * @subpackage samples_trading
 * @author johann 
 * @copyright Copyright (c) 2008
 * @version $Id: sample_GetCategories.php,v 1.107 2012-09-10 11:01:21 michaelcoslar Exp $
 * @access public
 */
class GetCategories extends eBayApiEnvironment
{

   /**
     * sample_GetCategories::dispatchCall()
     * 
     * Dispatch the call
     *
     * @param array $params array of parameters for the eBay API call
     * 
     * @return boolean success
     */
    public function dispatchCall ($params)
    {
        $req = new GetCategoriesRequestType();
		// $req->setCategoryParent($params['CategoryParent']);
		$req->setLevelLimit(2);
		$req->setDetailLevel("ReturnAll");
		
		set_time_limit(0);//I'm wondering if we will set it never goes timeout here.
		// until we have more efficient way of handling MU, we have to disable the limit
		$GLOBALS['db']->setQueryLimit(0);

        $res = $this->proxy->GetCategories($req);
        if ($this->testValid($res))
        {
            $this->dumpObject($res);
            return (true);
        }
        else 
        {
            return (false);
        }
    }

	public function retrieveCategories($params)
	{
		$this->session->setRequestToken($params['AuthToken']);
	}
}

?>
