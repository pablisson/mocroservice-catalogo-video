<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as CategoryModel;
use App\Repositories\Eloquent\CategoryRepository;
use Core\DTO\Category\UpdateCategory\UpdateCategoryInputDto;
use Core\UseCase\Category\UpdateCategoryUseCase;
use Tests\Unit\TestCase;

class UpdateCategoryUseCaseTest extends TestCase
{
    /**
     * A basic feature test example.
     */
	public function test_update(): void
    {
		$categoryModel = CategoryModel::factory()->create();

		$repository = new CategoryRepository($categoryModel);
		
		$useCase = new UpdateCategoryUseCase($repository);
		$responseUseCase = $useCase->execute(new UpdateCategoryInputDto(
			id: $categoryModel->id,
			name: 'Updated Category',
		));

		$this->assertEquals('Updated Category', $responseUseCase->name);
		$this->assertEquals($categoryModel->id, $responseUseCase->id);
		$this->assertDatabaseHas('categories', [
			'id' => $responseUseCase->id,
			'name' => 'Updated Category',
		]);
	
    }

}
