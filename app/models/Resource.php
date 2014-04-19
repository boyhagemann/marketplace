<?php

class Resource extends \Eloquent implements ModelInterface
{
	protected $fillable = array('name', 'uri', 'method');

    public function getIdentifier()
    {
        return $this->key;
    }


    public static function boot()
	{
		parent::boot();

		Resource::creating(function($route)
		{
			if(!$route->key) $route->key = Str::random(8);
		});
	}

}