<?php

namespace App\Models\Componentables;

use App\Models\Component;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;



class Image extends Model implements Componentable
{

	/**
	 * @var string
	 */
	protected $table = 'componentable_images';

	/**
	 * @var string[]
	 */
	protected $fillable = [
		'path',
		'width',
		'height'
	];



	/**
	 * @return MorphOne|Component
	 */
	public function component()
	{
		return $this->morphOne(Component::class, 'componentable');
	}
}
