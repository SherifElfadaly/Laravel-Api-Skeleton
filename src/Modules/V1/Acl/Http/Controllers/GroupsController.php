<?php
namespace App\Modules\V1\Acl\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use App\Modules\V1\Core\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;


class GroupsController extends BaseApiController
{
    /**
     * The name of the model that is used by the base api controller 
     * to preform actions like (add, edit ... etc).
     * @var string
     */
    protected $model               = 'groups';

    /**
     * The validations rules used by the base api controller
     * to check before add.
     * @var array
     */
    protected $validationRules  = [
    'name' => 'required|string|max:100|unique:groups,name,{id}'
    ];

    /**
     * Handle an assign permissions to group request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assignpermissions(Request $request)
    {
        $this->validate($request, [
            'permission_ids' => 'required|exists:permissions,id', 
            'group_id'       => 'required|array|exists:groups,id'
            ]);

        return \Response::json(\Core::groups()->assignPermissions($request->get('group_id'), $request->get('permission_ids')), 200);
    }

     /**
     *  Return the users in the given group in pages.
     * 
     * @param  integer $groupId
     * @param  integer $perPage
     * @param  string  $sortBy
     * @param  boolean $desc
     * @return \Illuminate\Http\Response
     */
    public function users($groupId, $perPage = 15, $sortBy = 'created_at', $desc = 1) 
    {
        if ($this->model) 
        {
            $relations = $this->relations && $this->relations['users'] ? $this->relations['users'] : [];
            return \Response::json(call_user_func_array("\Core::{$this->model}", [])->users($groupId, $perPage, $relations, $sortBy, $desc), 200);
        }
    }
}
