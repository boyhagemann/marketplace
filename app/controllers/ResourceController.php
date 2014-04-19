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
		return API::invokeRemote($resource->uri, $resource->method, Input::all());
	}

	/**
	 * Call multiple Resources and return a json response
	 *
	 * Example: GET /invoke?id=9IAH54IX&id=9IAH54IY
	 *
	 * @return Response
	 * @throws Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException
	 */
	public function multiple()
	{
		if(!Input::has('id')) {
			throw new \Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
		}

		foreach( (array) Input::get('id') as $key) {

			$resource = Resource::where('key', $key)->firstOrFail();
			$response[$key] = $this->invoke($resource);
		}

		return Response::json($response);
	}

	/**
	 * Call a resource and try to resolve it to a html string.
	 * It uses input parameters that correspond with the variable
	 * names in the template.
	 *
	 * If the input variable is a Resource id, then that view
	 * variable will be filled with the invoked Resource.
	 *
	 * @param Resource $resource
	 * @return string
	 */
	public function resolve(Resource $resource)
	{
		// Validation...

		$template = $this->invoke($resource);

		if(is_array($template)) {
			return Response::json($template);
		}

		$path = storage_path('test.blade.php');

		foreach(Input::all() as $var => $key) {

			try {
				$resource = Resource::where('key', $key)->firstOrFail();
				$data[$var] = $this->invoke($resource);
			}
			catch(Exception $e) {
				$data[$var] = $key;
			}
		}

		File::put($path, $template);

		View::addLocation(storage_path());

		$html = View::make('test', $data)->render();

		File::delete($path);

		return $html;
	}

}