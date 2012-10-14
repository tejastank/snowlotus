<?php
/**
 * sources
 */
require_once 'eBayApiEnvironment.php';
require_once 'ReviseItemRequestType.php';

class ReviseItem extends eBayApiEnvironment
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
        $req = new ReviseItemRequestType();
        
        $item = new ItemType();
        $item->setItemID($params['ItemID']);
        $item->setDescription($params['Description']);
		$item->setSKU($params['SKU']);
        $req->setItem($item);
		
        $res = $this->proxy->ReviseItem($req);
        if ($this->testValid($res))
        {
            return (true);
        }
        else 
        {
            $this->dumpObject($res);
            return (false);
        }
	}
}

?>
