<?php
/**
 * sources
 */
require_once 'eBayApiEnvironment.php';
require_once 'GeteBayOfficialTimeRequestType.php';

class GeteBayOfficialTime extends eBayApiEnvironment
{
	public $res;

   /**
     * sample_GeteBayOfficialTime::dispatchCall()
     * 
     * Dispatch the call
     *
     * @param array $params array of parameters for the eBay API call
     * 
     * @return boolean success
     */
    public function dispatchCall ($params)
    {
        $req = new GeteBayOfficialTimeRequestType();
		
        $res = $this->proxy->GeteBayOfficialTime($req);
        if ($this->testValid($res))
        {
			$this->res = $res;
			$this->dumpObject($res);
            return (true);
        }
        else 
        {
            return (false);
        }
    }
}

?>
