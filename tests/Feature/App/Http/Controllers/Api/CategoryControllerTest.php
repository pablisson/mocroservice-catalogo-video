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
use Illuminate\Database\Eloquent\Casts\Json;
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
		$payload = [
			'name' => 'New Category',
			'description' => 'New Description',
		];

		$response = $this->postJson(route('categories.store'), $payload);
		$response->assertStatus(Response::HTTP_CREATED);
		$this->assertEquals($payload['name'], $response['data']['name']);
		$this->assertEquals(Response::HTTP_CREATED, $response->status());
	}

	public function test_show()
	{
		$category = Category::factory()->create();
		$response = $this->getJson(route('categories.show', ['category' => $category->id]));
		
		$response->assertJsonStructure(
			[
				'data' => [
						'id',
						'name',
						'description',
						'created_at',
						'updated_at',
						'deleted_at',
						'is_active'
				]
			]
		);		
		$this->assertEquals($category->id, $response['data']['id']);
		$this->assertEquals($response['data']['name'], $response['data']['name']);
		$this->assertEquals(Response::HTTP_OK, $response->status());
	}


	public function test_update()
	{
		$category = Category::factory()->create();

		$payload = [
			'name' => 'Updated Category',
			'description' => 'Updated Description',
		];

		$response = $this->putJson(route('categories.update', ['category' => $category->id]), $payload);
		$response->assertStatus(Response::HTTP_OK);
		$this->assertNotEquals($category->name, $response['data']['name']);
		$response->assertJsonFragment([
			'name' => 'Updated Category',
		]);
	}

	public function test_delete()
	{
		$category = Category::factory()->create();
		
		$response = $this->deleteJson(route('categories.destroy', ['category' => $category->id]));
		$response->assertStatus(Response::HTTP_NO_CONTENT);

		$this->assertDatabaseMissing('categories', [
			'id' => $category->id,
		]);
	}

}
