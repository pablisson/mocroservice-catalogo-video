<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\Category as CategoryModel;
use App\Repositories\Eloquent\CategoryRepository;
use Core\Domain\Entity\Category as EntityCategory;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Unit\TestCase;

class CategoryRepositoryTeste extends TestCase
{
    /**
     * teste de integração
     */
    public function test_insert(): void
    {
		$categoryModel = new CategoryModel(
			[
				'id' => '123',
				'name' => 'Test Category',
				'description' => 'Test Description',
				'is_active' => true,
			]
			);
        $repository = new CategoryRepository($categoryModel);
		$entity = new EntityCategory(
			name: 'Test Category',
		);

		$response = $repository->insert($entity);

		$this->assertInstanceOf(CategoryRepositoryInterface::class, $repository);
		$this->assertInstanceOf(EntityCategory::class, $response);
		$this->assertDatabaseHas('categories', [
			'name' => 'Test Category',
		]);
    }
}
