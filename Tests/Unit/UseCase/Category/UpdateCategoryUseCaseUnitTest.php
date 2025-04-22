<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\DTO\Category\UpdateCategory\UpdateCategoryInputDto;
use Core\DTO\Category\UpdateCategory\UpdateCategoryOutputDto;
use Core\UseCase\Category\UpdateCategoryUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UpdateCategoryUseCaseUnitTest extends TestCase
{
	public function test_update_category()
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
			->shouldReceive('update')
			->andReturn($categoryEntity);
		
		$categoryEntity->update(
			name: $categoryName . ' updated',
			description: $categoryDescription
		);

		$mockInputDto = new UpdateCategoryInputDto(
			id: $categoryEntity->id,
			name: $categoryEntity->name,
			description: $categoryEntity->description,
			isActive: $categoryEntity->isActive
		);

		$useCase = new UpdateCategoryUseCase($mockRepository);
		$responseUseCase = $useCase->execute($mockInputDto);

		$this->isInstanceOf(UpdateCategoryOutputDto::class, $responseUseCase);
		$this->assertEquals($categoryEntity->id, $responseUseCase->id);
		$this->assertNotEquals($categoryName, $responseUseCase->name);
		$this->assertEquals($categoryDescription, $responseUseCase->description);

        /**
         * Spies
         */
        $spy = Mockery::spy(CategoryRepositoryInterface::class);
        $spy->shouldReceive('findById')->andReturn($categoryEntity);
        $spy->shouldReceive('update')->andReturn($categoryEntity);
        $useCase = new UpdateCategoryUseCase($spy);
        $useCase->execute($mockInputDto);
        $spy->shouldHaveReceived('findById');
        $spy->shouldHaveReceived('update');
	}
}