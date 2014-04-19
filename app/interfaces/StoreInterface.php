<?php

interface StoreInterface
{
    public function store();
    public function storeSuccess(ModelInterface $model);
    public function storeFailure(Array $messages);
}