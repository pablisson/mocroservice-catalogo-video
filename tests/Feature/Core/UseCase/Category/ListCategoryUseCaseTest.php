<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as CategoryModel;
use App\Repositories\Eloquent\CategoryRepository;
use Core\DTO\Category\CategoryInputDto;
use Core\DTO\Category\ListCategories\ListCategoriesInputDto;
use Core\DTO\Category\ListCategories\ListCategoriesOutputDto;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\Category\ListCategoryUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Unit\TestCase;

class ListCategoryUseCaseTest extends TestCase
{
    /**
     * A basic feature test example.
     */
	public function test_list_category(): void
	{
		$categoryModel = CategoryModel::factory()->create();
		$repository = new CategoryRepository(new CategoryModel());
		$useCase = new ListCategoryUseCase($repository);

		$responseUseCase = $useCase->execute(new CategoryInputDto(
			id: $categoryModel->id,
		));

		$this->assertEquals($categoryModel->id, $responseUseCase->id);
		$this->assertEquals($categoryModel->name, $responseUseCase->name);
		$this->assertEquals($categoryModel->description, $responseUseCase->description);
	}
}
