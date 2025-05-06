<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\Category as CategoryModel;
use App\Repositories\Eloquent\CategoryRepository;
use Core\Domain\Entity\Category as EntityCategory;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;
use Tests\Unit\TestCase;

class CategoryRepositoryTeste extends TestCase
{
	protected $repository;
	protected function setUp(): void
	{
		parent::setUp();
		$categoryModel = new CategoryModel(
			[
				'id' => '123',
				'name' => 'Test Category',
				'description' => 'Test Description',
				'is_active' => true,
			]
			);
        $this->repository = new CategoryRepository($categoryModel);
	}

    /**
     * teste de integração
     */
    public function test_insert(): void
    {

		$entity = new EntityCategory(
			name: 'Test Category',
		);

		$response = $this->repository->insert($entity);

		$this->assertInstanceOf(CategoryRepositoryInterface::class, $this->repository);
		$this->assertInstanceOf(EntityCategory::class, $response);
		$this->assertDatabaseHas('categories', [
			'name' => 'Test Category',
		]);
    }

	public function test_find_by_id(): void
	{
		$categoryModel = CategoryModel::factory()->create();
		$reponse = $this->repository->findById($categoryModel->id);

		$this->assertInstanceOf(EntityCategory::class, $reponse);
		$this->assertEquals($categoryModel->id, $reponse->id());

	}

	public function test_find_by_id_not_found(): void
	{
		try {
			$this->repository->findById('fake-id');

			$this->assertTrue(false, 'Não estou a exception');
		} catch (\Exception $e) {
			$this->assertInstanceOf(NotFoundException::class, $e);
		}
	}

	public function test_find_all(): void
	{
		$categories = CategoryModel::factory()->count(10)->create();
		$response = $this->repository->findAll();
		// $this->assertCount(10, $response);
		$this->assertEquals(count($categories), count($response));

	}

	public function test_paginate(): void
	{
		$categories = CategoryModel::factory()->count(20)->create();
		$response = $this->repository->paginate();

		$this->assertInstanceOf(PaginationInterface::class, $response);
		$this->assertEquals(20, $response->total());
		$this->assertCount(15, $response->items());
	}

	public function test_paginate_without_items(): void
	{
		$response = $this->repository->paginate();
		
		$this->assertInstanceOf(PaginationInterface::class, $response);
		$this->assertCount(0, $response->items());
	}
}
