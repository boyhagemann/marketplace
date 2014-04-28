<?php

/**
 * Class Contract
 *
 * @param Resource $resource
 */
class Contract extends \Eloquent implements ModelInterface
{
	protected $fillable = array();

    public function getIdentifier()
    {
        return $this->id;
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
	public function resource()
	{
		return $this->belongsTo('Resource');
	}

	/**
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function type()
	{
		return $this->belongsTo('ContractType', 'contract_type_id');
	}

}