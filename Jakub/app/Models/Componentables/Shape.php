<?php

namespace App\Models\Componentables;

use App\Models\Component;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;



/**
 * @property string $content
 */
class Shape extends Model implements Componentable
{

	/**
	 * @var string
	 */
	protected $table = 'componentable_shapes';

	/**
	 * @var string[]
	 */
	protected $fillable = [
		'shape_id',
		'color',
	];



	/**
	 * @return MorphOne|Component
	 */
	public function component()
	{
		return $this->morphOne(Component::class, 'componentable');
	}



	/**
	 * @return BelongsTo|\App\Models\Shape
	 */
	public function shape()
	{
		return $this->belongsTo(\App\Models\Shape::class);
	}



	/**
	 * @param string $value
	 */
	public function setColorAttribute($value)
	{
		$this->attributes['color'] = empty($value) ? null : $value;
	}



	/**
	 * @return string
	 */
	public function getContentAttribute()
	{
		return $this->shape->content;
	}
}
