<?php

namespace App\Interactions\Gallery;

use App\Contracts\Gallery\Manager;
use App\Contracts\Interactions\Components\CreateComponent;
use App\Contracts\Interactions\Gallery\UploadImageableFile as Contract;
use App\Contracts\Repositories\Gallery\ImageRepository;
use App\Gallery\Imageable;
use App\Gallery\ImageComponentArrayBuilder;
use App\Gallery\Support\ResponseCollection;
use App\Models\Gallery\Image;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Collection;



class UploadImageableFile implements Contract
{

	/**
	 * @var Manager
	 */
	protected $manager;

	/**
	 * @var ImageRepository
	 */
	protected $images;

	/**
	 * @var ResponseCollection
	 */
	protected $response;



	/**
	 * @param Manager $manager
	 * @param ImageRepository $images
	 */
	public function __construct(
		Manager $manager,
		ImageRepository $images
	) {
		$this->manager = $manager;
		$this->images = $images;

		$this->response = new ResponseCollection;
	}



	/**
	 * {@inheritdoc}
	 */
	public function handle(array $data, User $user, Project $project = null)
	{
		foreach ($data['files'] as $file) {
			$this->addToResponse(
				$this->manager->store($file, $user), $user, $project
			);
		}

		return $this->response;
	}



	/**
	 * @param Image $image
	 * @param Imageable $imageable
	 */
	protected function createImageComponent(Image $image, Imageable $imageable)
	{
		$this->response->addComponent(
			app(CreateComponent::class)->handle(
				ImageComponentArrayBuilder::build($image, $imageable)
			)
		);
	}



	/**
	 * @param Collection|Imageable[] $imageables
	 * @param User $user
	 * @param Project|null $project
	 */
	protected function addToResponse(Collection $imageables, User $user, Project $project = null)
	{
		foreach ($imageables as $imageable) {
			$this->response->addImage(
				$image = $this->images->create($imageable, $user, $project)
			);

			if ($image->project !== null) {
				$this->createImageComponent($image, $imageable);
			}
		}
	}
}
