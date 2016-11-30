<?php

namespace App\Contracts\Gallery;

use App\Gallery\Imageable;
use App\Models\User;
use Illuminate\Http\UploadedFile;



interface Manager
{

	/**
	 * @param UploadedFile $file
	 * @param User $user
	 * @return Imageable[]
	 */
	public function store(UploadedFile $file, User $user);
}
