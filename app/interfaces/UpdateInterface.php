<?php

interface UpdateInterface
{
    public function update(ModelInterface $model);
    public function updateSuccess(ModelInterface $model);
    public function updateFailure(ModelInterface $model, Array $messages);
}