<?php

namespace App\Configuration;

use Illuminate\Support\Facades\Storage;



trait ManagesDiskStorage
{

	/**
	 * @return string
	 */
	public static function fileSystemStoragePath()
	{
		return Storage::disk()->getDriver()->getAdapter()->getPathPrefix();
	}
}
