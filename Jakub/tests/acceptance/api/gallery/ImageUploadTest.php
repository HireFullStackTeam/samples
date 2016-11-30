<?php

namespace Tests\Acceptance\Api\Gallery;

use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use Tests\Support\UploadedFile;
use Tests\TestCase;



class ImageUploadTest extends TestCase
{

	/**
	 * @var string
	 */
	protected $path = 'tests/fixtures/images/1.jpg';

	/**
	 * @var string
	 */
	protected $directory = 'app/public/';



	/** @test */
	public function it_uploads_image_file()
	{
		$request = $this->post('gallery', [
			'files' => [
				UploadedFile::makeFrom($this->path),
			],
		]);

		$image = $request->decodeResponseJson()['data']['images']['data'][0];

		$this->seeInDatabase('user_gallery', [
			'id'   => $image['id'],
			'path' => $image['path'],
		]);

		$this->seeJsonStructure([
			'data' => [
				'images' => [
					'data' => [
						[
							'id',
							'path',
						],
					],
				],
			],
		]);

		$this->checksForFileExistence($image['path']);
	}



	/** @test */
	public function it_uploads_image_file_to_the_project()
	{
		$project = factory(Project::class)->create();

		$request = $this->post('gallery', [
			'files'      => [
				UploadedFile::makeFrom($this->path),
			],
			'project_id' => $project->id,
		]);

		$image = $request->decodeResponseJson()['data']['images']['data'][0];
		$component = $request->decodeResponseJson()['data']['components']['data'][0];

		$this->seeInDatabase('user_gallery', [
			'id'   => $image['id'],
			'path' => $image['path'],
		]);

		$this->seeInDatabase('componentable_images', [
			'path' => $component['componentable']['path'],
		]);

		$this->seeJsonStructure([
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

		$this->checksForFileExistence($image['path']);
		$this->checksForFileExistence($component['componentable']['path']);
	}



	/**
	 * @param string $path
	 */
	protected function checksForFileExistence($path)
	{
		$this->assertFileExists(storage_path($this->directory) . $path);

		Storage::delete($path);

		if (empty(Storage::allFiles(dirname($path))) === true) {
			Storage::deleteDirectory(dirname($path));
		};
	}

}
