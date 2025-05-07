<?php

namespace Tests\Feature\App\Http\Controllers\Api;

use App\Http\Controllers\Api\CategoryController;
use App\Models\Category;
use App\Repositories\Eloquent\CategoryRepository;
use Core\UseCase\Category\ListCategoriesUseCase;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Mockery\Mock;
use Tests\Unit\TestCase;

class CategoryControllerTest extends TestCase
{
	protected CategoryRepository $repository;

	protected function setUp(): void
	{
		$this->repository = new CategoryRepository(
			new Category()
		);
		parent::setUp();
	}
	
    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
		$useCase = new ListCategoriesUseCase($this->repository);

		$controller = new CategoryController();
		$response = $controller->index(
			request: new Request(),
			useCase: $useCase
		);

		$this->assertInstanceOf(AnonymousResourceCollection::class, $response);
		$this->assertArrayHasKey('meta', $response->additional);

	}
}
