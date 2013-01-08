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
		$req->setLevelLimit(3);
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
		$account_id = $params['AccountID'];
		$this->session->setRequestToken($params['AuthToken']);

		$account = BeanFactory::getBean('xeBayAccounts');
		if ($account->retrieve($account_id) === null)
			return false;

		$bean = BeanFactory::getBean('xeBayCategories');

        $req = new GetCategoriesRequestType();
		// $req->setLevelLimit(1);
		$req->setDetailLevel("ReturnAll");
		
		set_time_limit(60*10);

        $res = $this->proxy->GetCategories($req);
        $categoryCount = 0;
        if ($this->testValid($res)) {
		    $GLOBALS['db']->query("DELETE FROM xebaycategories WHERE xebaycategories.xebayaccount_id = '$account_id'");

			$account->category_count = $res->getCategoryCount();
			$account->category_update_time = $res->getUpdateTime();
			$account->category_version = $res->getCategoryVersion();
			$account->reserve_price_allowed = $res->getReservePriceAllowed();
			$account->reduce_reserve_allowed = $res->getReduceReserveAllowed();
			$account->minimum_reserve_price = $res->getMinimumReservePrice();
			$account->save();

			$categoryArray = $res->getCategoryArray();
            foreach($categoryArray as &$category) {
				$bean->xebayaccount_id = $account_id;
                $bean->autopay_enabled = $category->getAutoPayEnabled();
                $bean->b2bvat_enabled = $category->getB2BVATEnabled();
                $bean->bestoffer_enabled = $category->getBestOfferEnabled();
                $bean->category_id = $category->getCategoryID();
                $bean->category_level = $category->getCategoryLevel();
                $bean->name = $category->getCategoryName();
                $categoryParent = $category->getCategoryParentID();
                if (count($categoryParent) == 1) {
                    $bean->category_parent_id = $category->getCategoryParentID(0);
                } else {
                    echo $bean->name . " has many parents";
		            sugar_cleanup(true);
                }
                $bean->expired = $category->getExpired();
                $bean->intl_autos_fixed_cat = $category->getIntlAutosFixedCat();
                $bean->leaf_category = $category->getLeafCategory();
                $bean->lsd = $category->getLSD();
                $bean->orpa = $category->getORPA();
                $bean->orra = $category->getORRA();
                $bean->seller_guarantee_eligible = $category->getSellerGuaranteeEligible();
                $bean->virtual = $category->getVirtual();
                $bean->id = create_guid();
				$bean->new_with_id = true;
				$bean->save();
            }
            return (true);
        } else {
            $this->dumpObject($res);
            return (false);
        }
	}
}

?>
