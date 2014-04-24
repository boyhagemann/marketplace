<?php

/**
 * Class Resource
 *
 * @param Contract $contract
 */
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

    /**
     * 
     * @param string $value
     * @return array
     */
    public function getConfigAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * 
     * @param array $value
     */
    public function setConfigAttribute(Array $value)
    {
        $this->attributes['config']  = json_encode($value);
    }

	/**
	 * @return Contract
	 */
	public function contract()
	{
		return $this->belongsTo('Contract');
	}

	/**
	 * @param string $key
	 * @return Resource
	 */
	public static function findByKey($key)
	{
		return static::where('key', $key)->firstOrFail();
	}

}