<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\Category as CategoryModel;
use App\Repositories\Eloquent\CategoryRepository;
use Core\Domain\Entity\Category as EntityCategory;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Exception\NotFoundDomainException;
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

		// $entity = new EntityCategory(
		// 	name: 'Test Category',
		// );

		// $response = $this->repository->insert($entity);

		// $category = $this->repository->findById($response->id());

		// $this->assertInstanceOf(EntityCategory::class, $category);
		// $this->assertEquals($response->id(), $category->id());
	}

	public function test_find_by_id_not_found(): void
	{
		try {
			$this->repository->findById('fake-id');

			$this->assertTrue(false, 'Não estou a exception');
		} catch (\Exception $e) {
			$this->assertInstanceOf(NotFoundDomainException::class, $e);
		}
	}
}
