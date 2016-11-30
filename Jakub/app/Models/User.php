<?php

namespace App\Models;

use App\Models\Gallery\Image;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;



class User extends Authenticatable
{

	use CanHaveProjects;

	/**
	 * @var string[]
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
	];

	/**
	 * @var string[]
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];



	/**
	 * @return HasMany|Project[]
	 */
	public function projects()
	{
		return $this->hasMany(Project::class);
	}



	/**
	 * @return HasMany|Image[]
	 */
	public function gallery()
	{
		return $this->hasMany(Image::class);
	}
}
