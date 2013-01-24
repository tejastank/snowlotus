<?php
/**
 * sources
 */
require_once 'eBayShoppingApi.php';
require_once 'FindPopularSearchesRequestType.php';

/**
 * sampleshopping_FindPopularSearches
 * 
 * Sample call for FindPopularSearches
 * 
 * @package ebatns
 * @subpackage samples_shopping
 * @author johann 
 * @copyright Copyright (c) 2008
 * @version $Id: sampleshopping_FindPopularSearches.php,v 1.95 2012-09-10 11:14:11 michaelcoslar Exp $
 * @access public 
 */
class FindPopularSearches extends eBayShoppingApi
{

    /**
     * sampleshopping_FindPopularSearches::dispatchCall()
     * 
     * Dispatch the call
     *
     * @param array $params array of parameters for the eBay API call
     * 
     * @return boolean success
     */
	public function dispatchCall ($params)
    {
		$req = new FindPopularSearchesRequestType();
		if (!empty($params['CategoryID']))
            $req->setCategoryID($params['CategoryID']);
		if (!empty($params['IncludeChildCategories']))
            $req->setIncludeChildCategories($params['IncludeChildCategories']);
		if (!empty($params['MaxKeywords']))
            $req->setMaxKeywords($params['MaxKeywords']);
        if (!empty($params['MaxResultsPerPage']))
            $req->setMaxResultsPerPage($params['MaxResultsPerPage']);
		if (!empty($params['PageNumber']))
            $req->setPageNumber($params['PageNumber']);
		if (!empty($params['QueryKeywords']))
            $req->setQueryKeywords($params['QueryKeywords']);

		$res = $this->proxy->FindPopularSearches($req);
		if ($this->testValid($res))
        {
			$this->dumpObject($res);
            return (true);
        } else {
            return (false);
        }
    }
}

?>
