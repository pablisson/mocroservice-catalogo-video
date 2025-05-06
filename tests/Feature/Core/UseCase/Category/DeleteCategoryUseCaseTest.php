<?php

namespace Tests\Feature\Core\UseCase\Category;

use Tests\Unit\TestCase;
use App\Models\Category as CategoryModel;
use App\Repositories\Eloquent\CategoryRepository;
use Core\DTO\Category\DeleteCategories\DeleteCategoryInputDto;
use Core\UseCase\Category\DeleteCategoryUseCase;

class DeleteCategoryUseCaseTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_delete(): void
    {
		$categoryModel = CategoryModel::factory()->create();

		$repository = new CategoryRepository($categoryModel);
		
		$useCase = new DeleteCategoryUseCase($repository);
		$responseUseCase = $useCase->execute(new DeleteCategoryInputDto(
			id: $categoryModel->id,
		));

		$this->assertSoftDeleted($categoryModel);

    }
}
