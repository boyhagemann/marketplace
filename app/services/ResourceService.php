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

		Event::fire('invoke.response', array($resource, $params, $response));

        try {
            return $response->json();
        }
        catch(Guzzle\Common\Exception\RuntimeException $e) {
            return $response->getBody();
        }
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
	 * @param array    $params
	 * @return mixed
	 * @throws Exception
	 */
	public function resolve(Resource $resource, Array $params)
	{
		// If the resource is not of type template, then we can just call
		// the simple invoke method and skip the recursive resolve process.
		if($resource->type != 'template') {
			return $this->invoke($resource, $params);
		}

		// Get the config
		$contract = $this->getContract($resource, $params);

		switch($contract->type->name) {

			case 'form':
				$resolver = new TemplateResolver();
				break;

			case 'list':
				$resolver = new TemplateResolver();
				break;

			case 'template':
				$resolver = new TemplateResolver();
				break;

			case 'transformer':
				$resolver = new TransformerResolver();
				break;
		}

		return $resolver->resolve($this, $resource, $contract, $params);
	}

	/**
	 * @param $input
	 * @param Contract $contract
	 * @return string
	 */
	public function resolveInput(Array $input, Contract $contract)
	{
		if(!isset($input['source'])) {
			throw new Exception('The "source" data for template is missing');
		}

		if(!isset($input['params'])) {
			throw new Exception('The "params" data for template is missing');
		}

		$source = Resource::findByKey($input['source']);
		return $this->resolve($source, $input['params']);
	}
    
    /**
     * 
     * @param Resource $resource
     * @return Contract
     * @throws Exception
     */
    public function getContract(Resource $resource)
    {
		// Everey template must have a config that explains which keys needs
		// to be resolved.
		if(!$contract = $resource->contract) {
			throw new Exception(sprintf('Must provide a contract for resource %d', $resource->id));
		}

		// Does this contract already has a 'cached' config? No need to invoke, just return it.
        if($contract->config) {
            return $contract;
        }

		// Get the config data from the contract resource and 'cache' it
		$config = $this->invoke($contract->resource);
		$contract->config = $config;
		$contract->save();

        return $contract;
    }

}

interface ResourceResolverInterface
{
	public function resolve(ResourceService $service, Resource $resource, Contract $contract, Array $params);
}

class ListResolver implements ResourceResolverInterface
{
	public function resolve(ResourceService $service, Resource $resource, Contract $contract, Array $params)
	{
		return 'listed';
		dd($params);
	}
}

class FormResolver implements ResourceResolverInterface
{
	public function resolve(ResourceService $service, Resource $resource, Contract $contract, Array $params)
	{
		return 'formed';
		dd($params);
	}
}

class TemplateResolver implements ResourceResolverInterface
{
	/**
	 * @param ResourceService $service
	 * @param Resource        $resource
	 * @param Contract        $contract
	 * @param array           $params
	 * @return mixed
	 * @throws Exception
	 */
	public function resolve(ResourceService $service, Resource $resource, Contract $contract, Array $params)
	{
		$data = array();

		foreach(array_keys($contract->config) as $variable) {

			if(!isset($params[$variable])) {
				throw new Exception(sprintf('The template config misses the "%s" data', $variable));
			}

			$input = $params[$variable];

			$data[$variable] = $this->resolveInput($service, $input, $contract);
		}

		return $service->invoke($resource, $data);
	}

	/**
	 * @param ResourceService $service
	 * @param array|string    $input
	 * @param Contract        $contract
	 * @return string
	 */
	protected function resolveInput(ResourceService $service, $input, Contract $contract)
	{
		if(is_string($input)) {
			return $input;
		}

		if(!is_array($input)) {
			throw new Exception('Config needs a "source"');
		}


		if(isset($input['source'])) {
			return $service->resolveInput($input, $contract);
		}
		else {
			$data = '';
			foreach($input as $multiple) {
				$data .= $service->resolveInput($multiple, $contract);
			}
			return $data;
		}

	}

}

class TransformerResolver implements ResourceResolverInterface
{
	/**
	 * @param ResourceService $service
	 * @param Resource        $resource
	 * @param Contract        $contract
	 * @param array           $params
	 * @return mixed
	 * @throws Exception
	 */
	public function resolve(ResourceService $service, Resource $resource, Contract $contract, Array $params)
	{
		if(!isset($params['target'])) {
			throw new Exception('The "target" data for transformer is missing');
		}

		$target = Resource::findByKey($params['target']);
		$config = $service->getContract($target)->config;
		$data = array_merge($params, $config);

		return $service->invoke($resource, $data);
	}
}