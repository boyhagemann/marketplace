<?php

class ResourceController extends \BaseController implements StoreInterface, UpdateInterface, DestroyInterface
{
    /**
     *
     * @var ResourceService 
     */
     protected $service;
     
     /**
      * 
      * @param ResourceService $service
      */
     public function __construct(ResourceService $service)
     {
         $this->service = $service;
     }

     /**
	 * Resource index
	 *
	 * @return Response
	 */
	public function index()
	{
		$resources = Resource::all();

		return Request::ajax()
			? Response::json($resources)
			: View::make('resources.index', compact('resources'));
	}
    
    public function create()
    {
        return View::make('resources.create');
    }
    
    public function store()
    {
        return $this->service->store($this, Input::except('_token'));
    }
    
    public function storeSuccess(ModelInterface $model)
    {
        return Redirect::route('resource.index')->withSuccess('Yeah');
    }
    
    public function storeFailure(Array $messages)
    {
        return Redirect::route('resource.create')->withErrors($messages);
    }
    
    public function edit(Resource $resource)
    {
        return View::make('resources.edit', compact('resource'));
    }
    
    public function update(ModelInterface $model)
    {
        return $this->service->update($this, $model, Input::except('_token'));
    }

    public function updateSuccess(ModelInterface $model)
    {
        return Redirect::route('resource.edit', $model->getIdentifier())->withSuccess('Yeah');
    }
    
    public function updateFailure(ModelInterface $model, Array $messages)
    {
        return Redirect::route('resource.edit', $model->getIdentifier())->withErrors($messages);
    }
    
    public function destroy(ModelInterface $model)
    {
        return $this->service->destroy($this, $model);
    }
    
    public function destroySuccess()
    {
        return Redirect::route('resource.index')->withSuccess('Yeah');
    }
    
    public function destroyFailure(ModelInterface $model, Array $messages)
    {
        return Redirect::route('resource.index')->withErrors($messages);
    }


    /**
	 * Call one Resource uri and return the response
	 *
	 * Example: GET /invoke/9IAH54IX
	 *
	 * @param  Resource $resource
	 * @return Response
	 */
	public function invoke(Resource $resource)
	{
		return $this->service->invoke($resource, Input::all());
	}

	/**
	 * @param Resource $resource
	 * @return array
	 */
	public function config(Resource $resource)
	{
		return $resource->contract ? $resource->contract->config : array();
	}

	/**
	 * @param Resource $resource
	 * @return string
	 */
	public function refresh(Resource $resource)
	{
		$contract = $resource->contract;
		$contract->config = $this->service->invoke($contract->resource);
		$contract->save();

		return 'refreshed';
	}
}