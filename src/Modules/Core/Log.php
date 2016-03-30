<?php namespace App\Modules\Core;

class Log
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
	    		'user_id'     => \Auth::user()->id,
	    		], false, false);
    	}
    }
}