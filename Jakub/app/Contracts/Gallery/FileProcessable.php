<?php

namespace App\Contracts\Gallery;

use App\Gallery\Imageable;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;



interface FileProcessable
{

	/**
	 * @param UploadedFile $file
	 * @return Collection|Imageable[]
	 */
	public function store(UploadedFile $file);



	/**
	 * @param User $user
	 * @return $this
	 */
	public function forUser(User $user);
}
