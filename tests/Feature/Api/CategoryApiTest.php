<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
}