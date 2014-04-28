<?php

class ContractController extends \BaseController implements StoreInterface, UpdateInterface, DestroyInterface
{
    /**
     *
     * @var ContractService
     */
     protected $service;
     
     /**
      * 
      * @param ContractService $service
      */
     public function __construct(ContractService $service)
     {
         $this->service = $service;
     }

     /**
	 * Contract index
	 *
	 * @return Response
	 */
	public function index()
	{
		$contracts = Contract::all();

		return Request::ajax()
			? Response::json($contracts)
			: View::make('contracts.index', compact('contracts'));
	}
    
    public function create()
    {
        return View::make('contracts.create');
    }
    
    public function store()
    {
        return $this->service->store($this, Input::except('_token'));
    }
    
    public function storeSuccess(ModelInterface $model)
    {
        return Redirect::route('contract.index')->withSuccess('Yeah');
    }
    
    public function storeFailure(Array $messages)
    {
        return Redirect::route('contract.create')->withErrors($messages);
    }
    
    public function edit(Contract $contract)
    {
        return View::make('contracts.edit', compact('contract'));
    }
    
    public function update(ModelInterface $model)
    {
        return $this->service->update($this, $model, Input::except('_token'));
    }

    public function updateSuccess(ModelInterface $model)
    {
        return Redirect::route('contract.edit', $model->getIdentifier())->withSuccess('Yeah');
    }
    
    public function updateFailure(ModelInterface $model, Array $messages)
    {
        return Redirect::route('contract.edit', $model->getIdentifier())->withErrors($messages);
    }
    
    public function destroy(ModelInterface $model)
    {
        return $this->service->destroy($this, $model);
    }
    
    public function destroySuccess()
    {
        return Redirect::route('contract.index')->withSuccess('Yeah');
    }
    
    public function destroyFailure(ModelInterface $model, Array $messages)
    {
        return Redirect::route('contract.index')->withErrors($messages);
    }

}