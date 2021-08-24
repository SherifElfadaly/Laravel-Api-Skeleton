<?php

namespace App\Modules\Core\BaseClasses;

use App\Http\Controllers\Controller;
use App\Modules\Core\BaseClasses\Contracts\BaseServiceInterface;
use App\Modules\Core\Decorators\CachingDecorator;
use Illuminate\Http\Request;
use App\Modules\Core\Http\Resources\General as GeneralResource;
use Illuminate\Cache\Repository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class BaseApiController extends Controller
{
    /**
     * Array of eager loaded relations.
     *
     * @var array
     */
    protected $relations;

    /**
     * @var BaseServiceInterface
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
     * @param   BaseServiceInterface $service
     * @return  void
     */
    public function __construct(BaseServiceInterface $service)
    {
        $this->service = new CachingDecorator($service, App::make(Repository::class), App::make(Request::class), App::make(\Illuminate\Contracts\Session\Session::class));
    }

    /**
     * Fetch all records with relations from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $local = Session::get('locale') == 'all' ? 'en' : Session::get('locale');
        return $this->modelResource::collection($this->service->list($local, $request->relations, $request->query(), $request->query('perPage', 15), $request->query('sortBy', 'created_at'), $request->query('desc', false), $request->query('trashed', false)));
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
        $data = App::make($this->storeFormRequest)->validated();
        Session::put('locale', 'all');

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
        $data = App::make($this->storeFormRequest)->validated();
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
