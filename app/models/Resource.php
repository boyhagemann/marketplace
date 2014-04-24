<?php

/**
 * Class Resource
 *
 * @param Contract $contract
 * @param ContractType $contractType
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
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function contract()
	{
		return $this->belongsTo('Contract');
	}

	/**
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function contractType()
	{
		return $this->belongsTo('ContractType');
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