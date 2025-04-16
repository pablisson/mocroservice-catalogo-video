<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\DTO\Category\CategoryCreateInputDto;
use Core\DTO\Category\CategoryCreateOutputDto;
use Core\UseCase\Category\CreateCategoryUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class CreateCategoryUseCaseUnitTest extends TestCase
{
	protected $mockEntity;
	protected $mockRepository;
	protected $mockInputDto;
	protected $spy;
	
	public function test_create_new_category()
	{

		$categoryName = 'Category use case 1';
		$categoryDescription = 'Description 1';
		$categoryIsActive = true;

		$this->mockEntity = new Category(
				name: $categoryName,
				description: $categoryDescription,
				isActive: $categoryIsActive
		);

		$this->mockRepository = Mockery::mock(CategoryRepositoryInterface::class);
		$this->mockRepository
			->shouldReceive('insert')			
			->andReturn($this->mockEntity);
		
		$this->mockInputDto = new CategoryCreateInputDto(
			name: $categoryName,
			description: $categoryDescription,
			isActive: $categoryIsActive
		);

		$useCase = new CreateCategoryUseCase($this->mockRepository);
		$responseUseCase = $useCase->execute($this->mockInputDto);

		$this->isInstanceOf(CategoryCreateOutputDto::class, $responseUseCase);
		self::assertEquals($categoryName, $responseUseCase->name);
		self::assertEquals($categoryDescription, $responseUseCase->description);

		/**
		 * Spies para verificar se chamou o metodo insert
		 */
		$this->spy = Mockery::spy(CategoryRepositoryInterface::class);
		$this->spy
			->shouldReceive('insert')
			->once()
			->andReturn($this->mockEntity);
		$useCase = new CreateCategoryUseCase($this->spy);
		$responseUseCase = $useCase->execute($this->mockInputDto);
		$this->spy
			->shouldHaveReceived('insert');
		Mockery::close();
	}
	
}