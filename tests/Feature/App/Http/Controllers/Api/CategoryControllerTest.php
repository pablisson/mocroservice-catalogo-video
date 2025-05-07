<?php

namespace Tests\Feature\App\Http\Controllers\Api;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Controllers\Api\CategoryController;
use App\Models\Category;
use App\Repositories\Eloquent\CategoryRepository;
use Core\UseCase\Category\CreateCategoryUseCase;
use Core\UseCase\Category\ListCategoriesUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Js;
use Tests\Unit\TestCase;

class CategoryControllerTest extends TestCase
{
	protected CategoryRepository $repository;
	protected CategoryController $controller; 

	protected function setUp(): void
	{
		$this->repository = new CategoryRepository(
			new Category()
		);
		$this->controller = new CategoryController();
		parent::setUp();
	}
	
    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
		$useCase = new ListCategoriesUseCase($this->repository);

		$response = $this->controller->index(
			request: new Request(),
			useCase: $useCase
		);

		$this->assertInstanceOf(AnonymousResourceCollection::class, $response);
		$this->assertArrayHasKey('meta', $response->additional);

	}

	public function test_store()
	{
		$useCase = new CreateCategoryUseCase($this->repository);
		$request = new StoreCategoryRequest([
			'name' => 'Test Category',
			'description' => 'Test Description',
		]);
		
		// $request->headers->set('content-type', 'application/json');

		$response = $this->controller->store(
			$request,
			$useCase
		);
		$this->assertInstanceOf(JsonResponse::class, $response);
		$this->assertEquals(Response::HTTP_CREATED, $response->status());
	}
}
