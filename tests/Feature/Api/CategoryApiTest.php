<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;
use Tests\Unit\TestCase;

class CategoryApiTest extends TestCase
{
	protected $endpoint = '/api/categories';
	protected $model = 'Category';
    /**
     * A basic feature test example.
     */
    public function test_list_empty_categories(): void
    {
        $response = $this->getJson($this->endpoint);

        $response->assertStatus(200);
    }

	public function test_list_all_categories(): void
	{
		$categories = Category::factory()->count(30)->create();
		$response = $this->getJson($this->endpoint);
		$response->assertStatus(200);
		$response->assertJsonStructure(
			[
				'data' => [
					'*' => [
						'id',
						'name',
						'description',
						'created_at',
						'updated_at',
						'deleted_at',
						'is_active'
					]
				],
				'meta' => [
					'total',
					'last_page',
					'first_page',
					'current_page',
					'per_page',
					'from',
					'to'
				]
			]
		);
		$this->assertEquals($response['meta']['total'], $categories->count());

		$response = $this->getJson("$this->endpoint?page=2");
		$response->assertStatus(200);
		$this->assertEquals($response['meta']['current_page'], 2);
	}

	public function test_list_category_not_found(): void
	{
		Category::factory()->create();
		$uuid = Uuid::uuid4()->toString();

		$response = $this->getJson("$this->endpoint/{$uuid}");
		$response->assertStatus(Response::HTTP_NOT_FOUND);
		$response->assertJson([
			'message' => "Category id: {$uuid} not found"
		]);

	}
	public function test_list_category(): void
	{
		$category = Category::factory()->create();

		$response = $this->getJson("$this->endpoint/{$category->id}");
		$response->assertStatus(Response::HTTP_OK);
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
		$this->assertEquals($category->name, $response['data']['name']);
		$this->assertEquals($category->description, $response['data']['description']);
		
	}

	public function test_validation_store(): void
	{
		$response = $this->postJson($this->endpoint, []);
		$response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);		
		$response->assertJsonStructure([
			'message',
			'errors' => [
				'name',
			]
		]);

		$response = $this->postJson($this->endpoint, [
			'name' => 'No',
			'description' => 'De',
		]);
		$response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
		$response->assertJsonStructure([
			'message',
			'errors' => [
				'name',
				'description'
			]
		]);

		$response = $this->postJson($this->endpoint, [
			'name' => fake()->sentence(300),
			'description' => fake()->sentence(300),
		]);

		$response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
		$response->assertJsonStructure([
			'message',
			'errors' => [
				'name',
				'description'
			]
		]);

	}

	public function test_store(): void
	{
		$data = [
			'name' => 'Nova Category Test',
			'description' => 'Description Test',
			'is_active' => true,
		];
		$response = $this->postJson($this->endpoint, $data);
		$response->assertStatus(Response::HTTP_CREATED);		
		$response->assertJsonStructure([
			'data' => [
				'id',
				'name',
				'description',
				'created_at',
				'updated_at',
				'deleted_at',
				'is_active'
			]
		]);
		
	}

	public function test_not_found_update(): void
	{
		$uuid = Uuid::uuid4()->toString();
		$response = $this->putJson("$this->endpoint/{$uuid}", [
			'name' => 'Nova Categoria test',
		]);
		$response->assertStatus(Response::HTTP_NOT_FOUND);
		$response->assertJson([
			'message' => "Category id: {$uuid} not found"
		]);
	}

	public function test_validation_update(): void
	{
		$category = Category::factory()->create();
		$response = $this->putJson("$this->endpoint/{$category->id}", []);
		
		$response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);		
		$response->assertJsonStructure([
			'message',
			'errors' => [
				'name',
			]
		]);

		$response = $this->putJson("$this->endpoint/{$category->id}", [
			'name' => 'No',
			'description' => 'De',
		]);
		
		$response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
		$response->assertJsonStructure([
			'message',
			'errors' => [
				'name',
				'description'
			]
		]);

			$response = $this->postJson($this->endpoint, [
			'name' => fake()->sentence(300),
			'description' => fake()->sentence(300),
		]);

		$response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
		$response->assertJsonStructure([
			'message',
			'errors' => [
				'name',
				'description'
			]
		]);	
	}

	public function test_update(): void
	{
		$category = Category::factory()->create();
		$data = [
			'name' => 'Nova Category Test',
			'description' => 'Description Test',
			'is_active' => true,
		];
		$response = $this->putJson("$this->endpoint/{$category->id}", $data);
		
		$response->assertStatus(Response::HTTP_OK);		
		$response->assertJsonStructure([
			'data' => [
				'id',
				'name',
				'description',
				'created_at',
				'updated_at',
				'deleted_at',
				'is_active'
			]
		]);
		$this->assertDatabaseHas(
			'categories',
			[
				'id' => $category->id,
				'name' => $data['name'],
			]
		);
		
	}

	public function test_not_found_delete(): void
	{
		$uuid = Uuid::uuid4()->toString();
		$response = $this->deleteJson("$this->endpoint/{$uuid}");
		$response->assertStatus(Response::HTTP_NOT_FOUND);
		$response->assertJson([
			'message' => "Category id: {$uuid} not found"
		]);
	}

	public function test_delete(): void
	{
		$category = Category::factory()->create();
		$response = $this->deleteJson("$this->endpoint/{$category->id}");
		$response->assertStatus(Response::HTTP_NO_CONTENT);
		$this->assertSoftDeleted(
			'categories',
			[
				'id' => $category->id,
			]
		);
		
	}
}