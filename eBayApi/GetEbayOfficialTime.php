<?php
/**
 * sources
 */
require_once 'eBayTradingApi.php';
require_once 'GeteBayOfficialTimeRequestType.php';

class GeteBayOfficialTime extends eBayTradingApi
{
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
		$this->session->setRequestToken($params['AuthToken']);

        $req = new GeteBayOfficialTimeRequestType();
		
        $res = $this->proxy->GeteBayOfficialTime($req);
		$this->dumpObject($res);
        if ($this->testValid($res))
        {
            return (true);
        }
        else 
        {
            return (false);
        }
    }
}

?>
