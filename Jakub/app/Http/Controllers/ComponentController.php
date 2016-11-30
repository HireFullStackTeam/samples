<?php

namespace App\Http\Controllers;

use App\App;
use App\Contracts\Interactions\Components\CreateComponent;
use App\Contracts\Interactions\Components\DeleteComponent;
use App\Contracts\Interactions\Components\UpdateComponent;
use App\Exceptions\UndefinedFactoryException;
use App\Http\Requests\Components\StoreComponentRequest;
use App\Http\Requests\Components\UpdateComponentRequest;
use App\Models\Component;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;



class ComponentController extends Controller
{

	/**
	 * @param StoreComponentRequest $request
	 * @return RedirectResponse
	 */
	public function store(StoreComponentRequest $request)
	{
		try {
			App::interact(CreateComponent::class, [$request->all()]);

		} catch (UndefinedFactoryException $e) {
			return redirect()->back()->withErrors(['Chyba při vytváření komponenty!!!']);
		}

		return redirect()->back();
	}



	/**
	 * @param Component $component
	 * @return RedirectResponse
	 */
	public function destroy(Component $component)
	{
		App::interact(DeleteComponent::class, [$component]);

		return redirect()->back();
	}



	/**
	 * @param Component $component
	 * @return View
	 */
	public function edit(Component $component)
	{
		return view('components.edit', compact('component'));
	}



	/**
	 * @param UpdateComponentRequest $request
	 * @param Component $component
	 * @return RedirectResponse
	 */
	public function update(UpdateComponentRequest $request, Component $component)
	{
		App::interact(UpdateComponent::class, [
			$component, $request->all()
		]);

		return redirect()->route('project.show', $component->project);
	}

}
