<?php

namespace App\Http\Requests\Api;

use App\Models\Project;
use App\Validation\UploadImageableFileExtensionValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;



class UploadImageableRequest extends FormRequest
{

	use UploadImageableFileExtensionValidation;



	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return $this->user() && $this->user()->ownsTeam(
			Project::findOrFail($this->project_id)
		);
	}



	/**
	 * @return \Illuminate\Validation\Validator
	 */
	public function validator()
	{
		$validator = Validator::make($this->all(), [
			'files' => 'required',
		]);

		$validator->after(function (\Illuminate\Validation\Validator $validator) {
			$this->validateImageableFileExtension($validator, $this->files);
		});

		return $validator;
	}
}
