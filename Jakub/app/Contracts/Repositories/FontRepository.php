<?php

namespace App\Contracts\Repositories;

use App\Models\Font;
use FontLib\TrueType\File;



interface FontRepository
{

	/**
	 * @param $filename
	 * @param $isPublic
	 * @param File $font
	 * @return Font
	 */
	public function create($filename, $isPublic, File $font);
}
