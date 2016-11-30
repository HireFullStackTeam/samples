<?php

namespace App\Http\Controllers\Api;

use App\App;
use App\Contracts\Interactions\Gallery\UploadImageableFile;
use App\Models\Project;
use App\Transformers\Gallery\ImageTransformer;
use App\Transformers\Gallery\ResponseCollectionTransformer;
use Dingo\Api\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class GalleryController extends ApiController
{

	/**
	 * @return Response
	 */
	public function index()
	{
		return $this->response->collection(
			Auth::user()->gallery, new ImageTransformer
		);
	}



	/**
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$collection = App::interact(UploadImageableFile::class, [
			$request->all(), Auth::user(), $this->project($request),
		]);

		return $this->response->item($collection, new ResponseCollectionTransformer);
	}



	/**
	 * @param Request $request
	 * @return Project|null
	 */
	protected function project(Request $request)
	{
		return $request->has('project_id')
			? Project::find($request['project_id'])
			: null;
	}
}
