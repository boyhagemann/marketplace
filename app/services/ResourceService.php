<?php

class ResourceService
{
    /**
     * 
     * @param StoreInterface $controller
     * @param array $input
     * @return Response
     */
    public function store(StoreInterface $controller, Array $input)
    {
        $model = Resource::create($input);
        return $controller->storeSuccess($model);
    }

    /**
     * 
     * @param StoreInterface $controller
     * @param ModelInterface $model
     * @param array $input
     * @return Response
     */
    public function update(StoreInterface $controller, ModelInterface $model, Array $input)
    {
        $model->update($input);
        return $controller->storeSuccess($model);
    }
    
    /**
     * 
     * @param DestroyInterface $controller
     * @param ModelInterface $model
     * @return Response
     */
    public function destroy(DestroyInterface $controller, ModelInterface $model)
    {
        $model->delete();
        return $controller->destroySuccess();
    }

	/**
	 * Call one Resource uri and return the response
	 *
	 * Example: GET /invoke/9IAH54IX
	 *
	 * @param Resource $resource
	 * @param array    $params
	 * @return mixed
	 */
	public function invoke(Resource $resource, Array $params = array())
	{
        $client = new Guzzle\Http\Client;
        $request = $client->createRequest($resource->method, $resource->uri, null, $params);
        $response = $request->send($request);

        try {
            return $response->json();
        }
        catch(Guzzle\Common\Exception\RuntimeException $e) {
            return $response->getBody();
        }
	}

}