<?php

namespace Tests\Feature\App\Http\Controllers\Api;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Controllers\Api\CategoryController;
use App\Models\Category;
use App\Repositories\Eloquent\CategoryRepository;
use Core\UseCase\Category\CreateCategoryUseCase;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\Category\ListCategoryUseCase;
use Core\UseCase\Category\UpdateCategoryUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Mockery;
use Symfony\Component\HttpFoundation\ParameterBag;
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

	public function test_show()
	{
		$category = Category::factory()->create();
		$useCase = new ListCategoryUseCase($this->repository);		
		
		$response = $this->controller->show(
			id: $category->id,
			useCase: $useCase
		);

		$this->assertInstanceOf(JsonResponse::class, $response);
		$this->assertEquals(Response::HTTP_OK, $response->status());
	}


	public function test_update()
	{
		$category = Category::factory()->create();

		$payload = [
			'name' => 'Updated Category',
			'description' => 'Updated Description',
		];

		$response = $this->putJson(route('category.update', ['category' => $category->id]), $payload);
		$response->assertStatus(Response::HTTP_OK);
		$this->assertNotEquals($category->name, $response['data']['name']);
		$response->assertJsonFragment([
			'name' => 'Updated Category',
		]);
	}
}
