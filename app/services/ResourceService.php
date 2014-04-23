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
	public function invoke(Resource $resource, Array $params)
	{
		return API::invokeRemote($resource->uri, $resource->method, $params);
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
		// Validation...

		// If the resource is not of type template, then we can just call
		// the simple invoke method and skip the recursive resolve process.
		if($resource->type != 'template') {
			return $this->invoke($resource, $params);
		}

		// Everey template must have a config that explains which keys needs
		// to be resolved.
		if(!$resource->contract) {
			throw new Exception(sprintf('Must provide a contract for resource %d', $resource->id));
		}

		// Get the config
		$contract = $this->invoke($resource->contract, $params);
		$data = array();

		foreach(array_keys($contract) as $key) {

			// Check if there is input. If not, we just use an empty string in the template.
			$input = isset($params[$key]) ? $params[$key] : '';

			if(is_array($input)) {

				// Start with an empty string and add resolved data to it.
				$data[$key] = '';

				if(isset($input['source'])) {

					// There is one resource that needs to be resolved
					$data[$key] .= $this->resolve(Resource::findByKey($input['source']), $input['params']);

				}
				else {

					// The variable in the template needs to be resolved with multiple resources.
					// Resolve each resource and concatenate the resolved output.
					foreach($input as $multiple) {
						$data[$key] .= $this->resolve(Resource::findByKey($multiple['source']), $multiple['params']);
					}
				}

			}
			else {

				// No data needs to be resolved, we can use the input directly
				$data[$key] = $input;
			}

		}

		// Now we have all child resources resolved and collected all data.
		// We can call the parent template resource with the data and return
		// the html output.
		return $this->invoke($resource, $data);
	}

}