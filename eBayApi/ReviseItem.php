<?php
/**
 * sources
 */
require_once 'eBayTradingApi.php';
require_once 'ReviseItemRequestType.php';

class ReviseItem extends eBayTradingApi
{
   /**
     * sample_ReviseItem::dispatchCall()
     * 
     * Dispatch the call
     *
     * @param array $params array of parameters for the eBay API call
     * 
     * @return boolean success
     */
    public function dispatchCall ($params)
    {
        $req = new ReviseItemRequestType();
        
        $item = new ItemType();
        $item->setItemID($params['ItemID']);
        $item->setDescription($params['Description']);
		$item->setSKU($params['SKU']);
        $req->setItem($item);
		
        $res = $this->proxy->ReviseItem($req);
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

	public function ryi($params)
	{
		$this->session->setRequestToken($params['AuthToken']);

		$scope = $params['scope'];

        $req = new ReviseItemRequestType();
        
        $item = new ItemType();
        $item->setItemID($params['ItemID']);

		if (in_array('description', $scope))
        	$item->setDescription($params['Description']);

		if (in_array('sku', $scope)) {
			$item->setApplicationData($params['ApplicationData']);
			$item->setSKU($params['SKU']);
		}

		$item->setHitCounter("HiddenStyle");

        $req->setItem($item);
		
        $res = $this->proxy->ReviseItem($req);

		switch ($res->getAck()) {
		case AckCodeType::CodeType_Success:
            return true;
			break;

		case AckCodeType::CodeType_Warning:
			echo "Item ID: {$params['ItemID']}<br>";
            echo $this->proxy->getErrorsToString($res, true);
            return true;
			break;

		default:
			echo "Item ID: {$params['ItemID']}<br>";
            echo $this->proxy->getErrorsToString($res, true);
            $this->dumpObject($res);
            return false;
			break;
		}
	}
}

?>
