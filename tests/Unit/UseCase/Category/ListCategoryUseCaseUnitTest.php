<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\DTO\Category\CategoryOutputDto;
use Core\DTO\Category\CategoryInputDto;
use Core\UseCase\Category\ListCategoryUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ListCategoryUseCaseUnitTest extends TestCase
{
	
	public function test_list_category()
	{
		$uuid = Uuid::uuid4()->toString();
		$category = new Category(
			id: $uuid,
			name: 'Category List',
		);

		$mockRepository = Mockery::mock(CategoryRepositoryInterface::class);
		$mockRepository->shouldReceive('findById')
			->with($uuid)
			->andReturn($category);

		$mockInputDto = new CategoryInputDto(
			id : $uuid
		);
		$useCase = new ListCategoryUseCase($mockRepository);
		$response = $useCase->execute($mockInputDto);
		$this->assertInstanceOf(CategoryOutputDto::class, $response);
		$this->assertEquals($category->name, $response->name);
		$this->assertEquals($category->description, $response->description);
		$this->assertEquals($uuid, $category->id());

		/**
		 * Spies para verificar se chamou o metodo findById
		 */
		$spy = Mockery::spy(CategoryRepositoryInterface::class);
		$spy
			->shouldReceive('findById')
			->once()
			->with($uuid)
			->andReturn($category);
		$useCase = new ListCategoryUseCase($spy);
		$responseUseCase = $useCase->execute($mockInputDto);
		$spy->shouldHaveReceived('findById');
	}
}