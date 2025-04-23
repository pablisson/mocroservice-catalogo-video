<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\DTO\Category\DeleteCategories\DeleteCategoryInputDto;
use Core\DTO\Category\DeleteCategories\DeleteCategoryOutputDto;
use Core\UseCase\Category\DeleteCategoryUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DeleteCategoryUseCaseUnitTest extends TestCase
{
	public function test_delete_category()
	{
		$id = Uuid::uuid4()->toString();
		$categoryName = 'Category use case 1';
		$categoryDescription = 'Description 1';
		$categoryIsActive = true;

		$categoryEntity = new Category(
			id: $id,
			name: $categoryName,
			description: $categoryDescription,
			isActive: $categoryIsActive
		);

		$mockRepository = Mockery::mock(CategoryRepositoryInterface::class);
		$mockRepository
			->shouldReceive('findById')			
			->andReturn($categoryEntity);

		$mockRepository
			->shouldReceive('delete')
			->andReturn(true);
		
		$categoryEntity->delete();

		$deleteInputDto = new DeleteCategoryInputDto(
			id: $categoryEntity->id,
			name: $categoryEntity->name,
			description: $categoryEntity->description,
			isActive: $categoryEntity->isActive
		);

		$useCase = new DeleteCategoryUseCase($mockRepository);
		$responseUseCase = $useCase->execute($deleteInputDto);

		$this->isInstanceOf(DeleteCategoryOutputDto::class, $responseUseCase);
		$this->assertNotEquals($categoryEntity->deletedAt(), null);

		/**
		 * * Verifica se o método delete foi chamado
		 */
		$spy = Mockery::spy(CategoryRepositoryInterface::class);
		$spy->shouldReceive('delete')
			->andReturn(true);
		
		$useCase = new DeleteCategoryUseCase($spy);
		$responseUseCase = $useCase->execute($deleteInputDto);
		$spy->shouldHaveReceived('delete');
	}

	protected function tearDown(): void
	{
		Mockery::close();
		parent::tearDown();
	}

}