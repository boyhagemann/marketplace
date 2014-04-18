<?php

class ResourceController extends \BaseController {

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