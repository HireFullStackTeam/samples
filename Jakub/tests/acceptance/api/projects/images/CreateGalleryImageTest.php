<?php

namespace Tests\Acceptance\Api\Projects\Images;

use App\Models\Project;
use App\Models\User;
use File;
use Tests\Support\UploadedFile;
use Tests\TestCase;



class CreateGalleryImageTest extends TestCase
{

	/**
	 * @var string
	 */
	protected $jpg = 'tests/fixtures/images/1.jpg';



	/** @test */
	public function it_creates_one_gallery_image_from_jpeg()
	{
		$user = factory(User::class)->create();
		$project = factory(Project::class)->create();

		$jpg = UploadedFile::makeFrom($this->jpg);

		$request = $this->post('/gallery', [
			'user_id'    => $user->id,
			'project_id' => $project->id,
			'files'      => [
				$jpg,
			],
		]);

		$request->seeJsonStructure([
			'data' => [
				'images'     => [
					'data' => [
						[
							'id',
							'path',
						],
					],
				],
				'components' => [
					'data' => [
						[
							'id',
							'visibility',
							'position_x',
							'position_y',
							'height',
							'width',
							'order',
							'componentable_type',
							'componentable' => [
								'path',
							],
						],
					],
				],
			],
		]);

		$this->seeInDatabase('components', [
			'project_id' => $project->id,
		]);

		// Files clean up
		foreach ($request->decodeResponseJson()['data']['images']['data'] as $image) {
			File::delete(storage_path('app/public/') . $image['path']);
		}

		foreach ($request->decodeResponseJson()['data']['components']['data'] as $image) {
			File::delete(storage_path('app/public/') . $image['componentable']['path']);
		}
	}
}
