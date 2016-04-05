<?php namespace App\Modules\V1\Core\Utl;

class Logging
{
    public function saveLog($action, $item_name, $item_type, $item_id, $model = false)
    {
    	if (\Core::logs() && $item_name !== 'Log')
    	{
            $item_name = $item_name;
    		\Core::logs()->save([
	    		'action'      => $action,
	    		'item_name'   => $item_name,
	    		'item_type'   => $item_type,
	    		'item_id'     => $item_id,
	    		'user_id'     => \JWTAuth::parseToken()->authenticate()->id,
	    		], false, false);
    	}
    }
}