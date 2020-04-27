<?php

namespace App\Modules\Core\BaseClasses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Core\Http\Resources\General as GeneralResource;

class BaseApiController extends Controller
{
    /**
     * Array of eager loaded relations.
     *
     * @var array
     */
    protected $relations;

    /**
     * @var object
     */
    protected $service;

    /**
     * Path of the model resource.
     *
     * @var string
     */
    protected $modelResource;

    /**
     * Path of the sotre form request.
     *
     * @var string
     */
    protected $storeFormRequest;

    /**
     * Init new object.
     *
     * @param   mixed      $service
     * @return  void
     */
    public function __construct($service)
    {
        $this->service = $service;
    }

    /**
     * Fetch all records with relations from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->modelResource::collection($this->service->list($request->relations, $request->query(), $request->query('perPage'), $request->query('sortBy'), $request->query('desc'), $request->query('trashed')));
    }

    /**
     * Fetch the single object with relations from storage.
     *
     * @param  Request $request
     * @param  integer $id Id of the requested model.
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        return new $this->modelResource($this->service->find($id, $request->relations));
    }

    /**
     * Insert the given model to storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $data = \App::make($this->storeFormRequest)->validated();
        return new $this->modelResource($this->service->save($data));
    }

    /**
     * Update the given model to storage.
     *
     * @param integer   $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $data = \App::make($this->storeFormRequest)->validated();
        $data['id'] = $id;
        return new $this->modelResource($this->service->save($data));
    }

    /**
     * Delete by the given id from storage.
     *
     * @param  integer $id Id of the deleted model.
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return new GeneralResource($this->service->delete($id));
    }

    /**
     * Restore the deleted model.
     *
     * @param  integer $id Id of the restored model.
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        return new GeneralResource($this->service->restore($id));
    }
}
