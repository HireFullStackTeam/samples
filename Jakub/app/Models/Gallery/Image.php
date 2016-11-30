<?php

namespace App\Models\Gallery;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class Image extends Model
{

	/**
	 * @var string
	 */
	protected $table = 'user_gallery';

	/**
	 * @var string[]
	 */
	protected $fillable = [
		'user_id',
		'path',
		'width',
		'height'
	];



	/**
	 * @return BelongsTo|User
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}



	/**
	 * @return BelongsTo|Project
	 */
	public function project()
	{
		return $this->belongsTo(Project::class);
	}

}
