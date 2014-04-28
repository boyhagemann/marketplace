<?php

class ContractService
{
    /**
     * 
     * @param StoreInterface $controller
     * @param array $input
     * @return Response
     */
    public function store(StoreInterface $controller, Array $input)
    {
        $model = Contract::create($input);
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


}