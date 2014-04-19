<?php

interface DestroyInterface
{
    public function destroy(ModelInterface $model);
    public function destroySuccess();
    public function destroyFailure(ModelInterface $model, Array $messages);
}