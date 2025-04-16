<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;
use Core\DTO\Category\ListCategories\ListCategoriesInputDto;
use Core\DTO\Category\ListCategories\ListCategoriesOutputDto;
use Core\Teste;
use Core\UseCase\Category\ListCategoriesUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;

class ListCategoriesUseCaseUnitTest extends TestCase
{
	public function test_listCategories_empty()
	{
		$mockPagination = Mockery::mock(PaginationInterface::class);
		$mockPagination
			->shouldReceive('items')
			->andReturn([]);

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
	}
}