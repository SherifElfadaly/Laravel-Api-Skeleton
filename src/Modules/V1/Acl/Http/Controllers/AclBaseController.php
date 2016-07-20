<?php
namespace App\Modules\V1\Acl\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use App\Modules\V1\Core\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;


class AclBaseController extends BaseApiController
{
    public function __construct()
    {
        parent::__construct();
    }
}
