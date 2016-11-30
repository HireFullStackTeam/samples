<?php

namespace App\Models\Feed;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class Product extends Model
{

	/**
	 * @var string[]
	 */
	protected $fillable = [
		'title',
		'price',
		'link',
		'image_link',
		'condition',
		'availability',
		'external_id'
	];



	/**
	 * @return BelongsTo|Project
	 */
	public function project()
	{
		return $this->belongsTo(Project::class);
	}
}
