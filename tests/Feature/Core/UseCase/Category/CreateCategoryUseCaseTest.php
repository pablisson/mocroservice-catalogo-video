<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as CategoryModel;
use App\Repositories\Eloquent\CategoryRepository;
use Core\DTO\Category\CreateCategory\CreateCategoryInputDto;
use Core\UseCase\Category\CreateCategoryUseCase;
use PHPUnit\Event\Code\Test;
use Tests\Unit\TestCase;

class CreateCategoryUseCaseTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create(): void
    {
		$categoryModel = new CategoryModel();
		$repository = new CategoryRepository($categoryModel);
		$useCase = new CreateCategoryUseCase($repository);

		$responseUseCase = $useCase->execute(new CreateCategoryInputDto(
			name: 'Test Category',
		));

		$this->assertEquals('Test Category', $responseUseCase->name);
		$this->assertNotEmpty($responseUseCase->id);
		$this->assertDatabaseHas('categories', [
			'id' => $responseUseCase->id,
		]);
    }
}
