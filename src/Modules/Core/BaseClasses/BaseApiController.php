<?php

namespace App\Modules\Core\BaseClasses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Core\Http\Resources\General as GeneralResource;
use App\Modules\Core\Decorators\CachingDecorator;

class BaseApiController extends Controller
{
    /**
     * The relations implementation.
     *
     * @var array
     */
    protected $relations;

    /**
     * The repo implementation.
     *
     * @var object
     */
    protected $repo;

    /**
     * Init new object.
     *
     * @param   mixed      $repo
     * @param   string     $modelResource
     * @return  void
     */
    public function __construct($repo, $modelResource)
    {
        $this->repo = new CachingDecorator($repo, \App::make('Illuminate\Contracts\Cache\Repository'));
        $this->modelResource = $modelResource;
    }

    /**
     * Fetch all records with relations from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->modelResource::collection($this->repo->list($request->relations, $request->query(), $request->query('perPage'), $request->query('sortBy'), $request->query('desc')));
    }

    /**
     * Fetch the single object with relations from storage.
     *
     * @param  Request $request
     * @param  integer $id Id of the requested model.
     * @return \Illuminate\Http\Response
     */
    public function find(Request $request, $id)
    {
        return new $this->modelResource($this->repo->find($id, $request->relations));
    }

    /**
     * Delete by the given id from storage.
     *
     * @param  integer $id Id of the deleted model.
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        return new GeneralResource($this->repo->delete($id));
    }

    /**
     * Return the deleted models in pages based on the given conditions.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function deleted(Request $request)
    {
        return $this->modelResource::collection($this->repo->deleted($request->all(), $request->query('perPage'), $request->query('sortBy'), $request->query('desc')));
    }

    /**
     * Restore the deleted model.
     *
     * @param  integer $id Id of the restored model.
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        return new GeneralResource($this->repo->restore($id));
    }
}
