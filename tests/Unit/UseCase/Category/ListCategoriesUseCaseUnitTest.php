<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;
use Core\DTO\Category\ListCategories\ListCategoriesInputDto;
use Core\DTO\Category\ListCategories\ListCategoriesOutputDto;
use Core\UseCase\Category\ListCategoriesUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class ListCategoriesUseCaseUnitTest extends TestCase
{
	public function test_listCategories_empty()
	{
		$mockPagination = $this->mockPagination();

		$mockRepository = Mockery::mock(CategoryRepositoryInterface::class);
		$mockRepository
			->shouldReceive('paginate')
			->andReturn($mockPagination);
		
		$mockInputDto = new ListCategoriesInputDto(
			page: 1,
			order: 'ASC',
			filter: '',				
		);

		$useCase = new ListCategoriesUseCase($mockRepository);
		$response = $useCase->execute($mockInputDto);

		$this->assertCount(0, $response->items);
		$this->isInstanceOf(ListCategoriesOutputDto::class,$response);

		/**
		 * Spies
		 */
		$spy = Mockery::spy(CategoryRepositoryInterface::class);
		$spy->shouldReceive('paginate')
			->andReturn($mockPagination);
		$useCase = new ListCategoriesUseCase($spy);
		$response = $useCase->execute($mockInputDto);
		$spy->shouldHaveReceived('paginate');

	}

	protected function mockPagination(array $items = []): PaginationInterface
	{
		$mockPagination = Mockery::mock(PaginationInterface::class);
		$mockPagination
			->shouldReceive('items')
			->andReturn( $items);
		$mockPagination
			->shouldReceive('total')
			->andReturn(0);
		$mockPagination
			->shouldReceive('currentPage')
			->andReturn(0);
		$mockPagination
			->shouldReceive('perPage')
			->andReturn(0);
		$mockPagination
			->shouldReceive('lastPage')
			->andReturn(0);
		$mockPagination
			->shouldReceive('firstPage')
			->andReturn(0);
		$mockPagination
			->shouldReceive('to')
			->andReturn(0);
		$mockPagination
			->shouldReceive('from')
			->andReturn(0);

		return $mockPagination;
	}
	
	protected function tearDown(): void
	{
		Mockery::close();
		parent::tearDown();
	}

	public function test_list_categories()
	{
		$register = new stdClass();
		$register->id = '1';
		$register->name = 'Category 1';
		$register->description = 'Description 1';
		$register->is_active = true;
		$register->created_at = '2023-01-01 00:00:00';

		$register1 = new stdClass();
		$register1->id = '2';
		$register1->name = 'Category 2';
		$register1->description = 'Description 2';
		$register1->is_active = true;
		$register1->created_at = '2023-01-01 00:00:00';

		$mockPagination = $this->mockPagination([
			$register, $register1
		]);

		$mockRepository = Mockery::mock(CategoryRepositoryInterface::class);
		$mockRepository
			->shouldReceive('paginate')
			->andReturn($mockPagination);
		
		$mockInputDto = new ListCategoriesInputDto(
			page: 1,
			order: 'ASC',
			filter: '',				
		);

		$useCase = new ListCategoriesUseCase($mockRepository);
		$response = $useCase->execute($mockInputDto);

		$this->assertCount(2, $response->items);
		$this->isInstanceOf(stdClass::class,$response->items[0]);
		$this->isInstanceOf(ListCategoriesOutputDto::class,$response);

		/**
		 * Spies
		 */
		$spy = Mockery::spy(CategoryRepositoryInterface::class);
		$spy->shouldReceive('paginate')
			->andReturn($mockPagination);
		$useCase = new ListCategoriesUseCase($spy);
		$response = $useCase->execute($mockInputDto);
		$spy->shouldHaveReceived('paginate');

	}
}