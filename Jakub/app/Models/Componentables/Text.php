<?php

namespace App\Models\Componentables;

use App\Models\Component;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;



class Text extends Model implements Componentable
{

	/**
	 * @var string
	 */
	protected $table = 'componentable_texts';

	/**
	 * @var string[]
	 */
	protected $fillable = [
		'content',
		'state'
	];



	/**
	 * @return MorphOne|Component
	 */
	public function component()
	{
		return $this->morphOne(Component::class, 'componentable');
	}



	/**
	 * @param string $value
	 */
	public function setContentAttribute($value)
	{
		$this->attributes['content'] = empty($value) ? null : $value;
	}



	/**
	 * @param string $value
	 */
	public function setStateAttribute($value)
	{
		$this->attributes['state'] = empty($value) ? null : $value;
	}
}
