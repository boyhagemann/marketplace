<?php

class Resource extends \Eloquent {
	protected $fillable = array();

	public static function boot()
	{
		parent::boot();

		Resource::creating(function($route)
		{
			if(!$route->key) $route->key = Str::random(8);
		});
	}

}