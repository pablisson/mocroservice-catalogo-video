<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\DTO\Category\CategoryInputDto;
use Core\DTO\Category\CategoryOutputDto;
use Core\UseCase\Category\CreateCategoryUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;


class CreateCategoryUseCaseUnitTest extends TestCase
{
	public function test_create_new_category()
	{
		$categoryName = 'Category use case 1';
		$categoryDescription = 'Description 1';
		$categoryIsActive = true;

		$mockEntity = new Category(
				name: $categoryName,
				description: $categoryDescription,
				isActive: $categoryIsActive
		);

		$mockRepository = Mockery::mock(CategoryRepositoryInterface::class);
		$mockRepository
			->shouldReceive('insert')			
			->andReturn($mockEntity);
		
		$mockInputDto = new CategoryInputDto(
			name: $categoryName,
			description: $categoryDescription,
			isActive: $categoryIsActive
		);

		$useCase = new CreateCategoryUseCase($mockRepository);
		$responseUseCase = $useCase->execute($mockInputDto);

		$this->isInstanceOf(CategoryOutputDto::class, $responseUseCase);
		$this->assertEquals($categoryName, $responseUseCase->name);
		$this->assertEquals($categoryDescription, $responseUseCase->description);

		/**
		 * Spies para verificar se chamou o metodo insert
		 */
		$spy = Mockery::spy(CategoryRepositoryInterface::class);
		$spy
			->shouldReceive('insert')
			->once()
			->andReturn($mockEntity);
		$useCase = new CreateCategoryUseCase($spy);
		$responseUseCase = $useCase->execute($mockInputDto);
		$spy->shouldHaveReceived('insert');
		Mockery::close();
	}
	
}