<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as CategoryModel;
use App\Repositories\Eloquent\CategoryRepository;
use Core\DTO\Category\ListCategories\ListCategoriesInputDto;
use Core\DTO\Category\ListCategories\ListCategoriesOutputDto;
use Core\UseCase\Category\ListCategoriesUseCase;
use Tests\Unit\TestCase;

class ListCategoriesUseCaseTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_list_categories(): void
    {
		$categoryModel = new CategoryModel();
		$repository = new CategoryRepository($categoryModel);
		$useCase = new ListCategoriesUseCase($repository);

		$responseUseCase = $useCase->execute(new ListCategoriesInputDto());
		$this->assertCount(0, $responseUseCase->items);

    }

	public function test_list_empty_categories(): void
	{
		$categoriesModel = CategoryModel::factory()->count(20)->create();
		$repository = new CategoryRepository(new CategoryModel());
		$responseUseCase = new ListCategoriesUseCase($repository);

		$responseUseCase = $responseUseCase->execute(new ListCategoriesInputDto());

		$this->assertInstanceOf(ListCategoriesOutputDto::class, $responseUseCase);
		$this->assertCount(15, $responseUseCase->items);
		$this->assertEquals(count($categoriesModel), $responseUseCase->total);
	}
}
