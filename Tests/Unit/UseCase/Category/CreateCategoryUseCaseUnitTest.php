<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\CreateCategoryUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class CreateCategoryUseCaseUnitTest extends TestCase
{
	protected $mockEntity;
	protected $mockRepository;
	public function test_create_new_category()
	{
		$uuid ='';

		$category = new Category(
			name: 'Category 1',
			id: $uuid,
			description: 'Description 1',
			isActive: true,
			createdAt: '2023-10-01 00:00:00'
		);
		
		$this->mockRepository = Mockery::mock(CategoryRepositoryInterface::class);
		$this->mockRepository->shouldReceive('insert')
			->once()
			->andReturn($category);
		
		$useCase = new CreateCategoryUseCase(
			$this->mockRepository
		);
		$useCase->execute();

		$this->assertTrue(true);
		Mockery::close();
	}
}