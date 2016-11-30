<?php

namespace Tests\Acceptance\Api\Gallery;

use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use Tests\Support\UploadedFile;
use Tests\TestCase;



class PhotoshopUploadTest extends TestCase
{

	/**
	 * @var string
	 */
	protected $path = 'tests/fixtures/images/psds/1.psd';

	/**
	 * @var string
	 */
	protected $directory = 'app/public/';

	/**
	 * @var string[]
	 */
	protected $componentsStructure = [
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
	];



	/** @test */
	public function it_uploads_a_photoshop_file()
	{
		$request = $this->post('gallery', [
			'files' => [
				UploadedFile::makeFrom($this->path),
			],
		]);

		$this->seeJsonStructure([
			'data' => [
				'images' => [
					'data' => [
						'*' => [
							'id',
							'path',
						],
					],
				],
			],
		]);

		$this->seeInDatabase('user_gallery', [
			'id'   => $request->decodeResponseJson()['data']['images']['data'][0]['id'],
			'path' => $request->decodeResponseJson()['data']['images']['data'][0]['path'],
		]);

		$this->checksForFileExistence(
			$request->decodeResponseJson()['data']['images']['data'][0]['path']
		);

		$this->checksForFileExistence(
			$request->decodeResponseJson()['data']['images']['data'][1]['path']
		);
	}



	/** @test */
	public function it_uploads_a_photoshop_file_to_the_project()
	{
		$project = factory(Project::class)->create();

		$request = $this->post('gallery', [
			'files'      => [
				UploadedFile::makeFrom($this->path),
			],
			'project_id' => $project->id,
		]);

		$this->seeJsonStructure([
			'data' => [
				'images'     => [
					'data' => [
						'*' => [
							'id',
							'path',
						],
					],
				],
				'components' => [
					'data' => [
						'*' => $this->componentsStructure,
					],
				],
			],
		]);

		for ($i = 0; $i < 2; $i++) {
			$image = $request->decodeResponseJson()['data']['images']['data'][$i];
			$componentPath = $request->decodeResponseJson()['data']['components']['data'][$i]['componentable']['path'];

			$this->checksForFileExistence($image['path']);
			$this->checksForFileExistence($componentPath);

			$this->seeInDatabase('user_gallery', [
				'id'   => $image['id'],
				'path' => $image['path'],
			]);

			$this->seeInDatabase('componentable_images', ['path' => $componentPath]);
		}

		$this->assertCount(2, $request->decodeResponseJson()['data']['images']['data']);
		$this->assertCount(2, $request->decodeResponseJson()['data']['components']['data']);
	}



	/** @test */
	public function it_checks_photoshop_upload_by_project_request()
	{
		$project = factory(Project::class)->create();

		$request = $this->post('gallery', [
			'files'      => [
				UploadedFile::makeFrom($this->path),
			],
			'project_id' => $project->id,
		]);

		for ($i = 0; $i < 2; $i++) {
			$this->checksForFileExistence(
				$request->decodeResponseJson()['data']['images']['data'][$i]['path']
			);

			$this->checksForFileExistence(
				$request->decodeResponseJson()['data']['components']['data'][$i]['componentable']['path']
			);
		}

		$this->get('project/' . $project->id);

		$this->seeJsonStructure([
			'data' => [
				'id',
				'name',
				'type'       => [
					'data' => [
						'name',
						'width',
						'height',
					],
				],
				'components' => [
					'data' => [
						'*' => $this->componentsStructure,
					],
				],
			],
		]);
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
