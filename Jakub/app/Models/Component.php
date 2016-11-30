<?php

namespace App\Models;

use App\Models\Componentables\Componentable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;



class Component extends Model
{

	/**
	 * @var string[]
	 */
	protected $fillable = [
		'name',
		'position_x',
		'position_y',
		'height',
		'width',
		'sequence',
		'project_id',
		'visibility',
		'order',
	];

	/**
	 * @var array
	 */
	protected $casts = [
		'visibility' => 'boolean',
	];



	/**
	 * @return BelongsTo|Project
	 */
	public function project()
	{
		return $this->belongsTo(Project::class);
	}



	/**
	 * @return MorphTo|Componentable
	 */
	public function componentable()
	{
		return $this->morphTo();
	}



	public function delete()
	{
		$this->componentable()->delete();

		parent::delete();
	}



	/**
	 * @param string $attribute
	 */
	public function setVisibilityAttribute($attribute)
	{
		$this->attributes['visibility'] = filter_var($attribute, FILTER_VALIDATE_BOOLEAN);
	}
}
