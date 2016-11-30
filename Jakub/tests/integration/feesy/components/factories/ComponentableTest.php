<?php

namespace Tests\Integration\Feesy\Components\Factories;

use App\Feesy\Components\Factories\ComponentableFactory;
use App\Models\Componentables\Shape;
use App\Models\Componentables\Text;
use Tests\TestCase;



class ComponentableTest extends TestCase
{

	/** @test */
	public function it_checks_form_name_for_text_componentable_exists()
	{
		$factory = app(ComponentableFactory::class);

		$this->assertSame('text', $factory->formArrayName(Text::class));
	}



	/** @test */
	public function it_checks_form_name_for_shape_componentable_exists()
	{
		$factory = app(ComponentableFactory::class);

		$this->assertSame('shape', $factory->formArrayName(Shape::class));
	}

}
