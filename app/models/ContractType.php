<?php

/**
 * Class Contract
 *
 * @param Resource $resource
 */
class ContractType extends \Eloquent implements ModelInterface
{
	protected $fillable = array();

    public function getIdentifier()
    {
        return $this->id;
    }

	/**
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function contract()
	{
		return $this->hasMany('Contract');
	}

}