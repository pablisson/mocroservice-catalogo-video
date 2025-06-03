<?php

namespace Tests\Unit\UseCase\Genre;

use Core\Domain\Repository\GenreRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;
use Core\DTO\Genre\ListGenres\ListGenresInputDto;
use Core\DTO\Genre\ListGenres\ListGenresOutputDto;
use Core\UseCase\Genre\ListGenresUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class ListGenresUseCaseUnitTest extends TestCase
{

	protected function mockPagination(array $items = []): PaginationInterface
	{
		$mockPagination = Mockery::mock(PaginationInterface::class);
		$mockPagination->shouldReceive('items')->andReturn([]);
		$mockPagination->shouldReceive('total')->andReturn(0);
		$mockPagination->shouldReceive('currentPage')->andReturn(1);
		$mockPagination->shouldReceive('lastPage')->andReturn(1);
		$mockPagination->shouldReceive('firstPage')->andReturn(1);
		$mockPagination->shouldReceive('perPage')->andReturn(15);
		$mockPagination->shouldReceive('to')->andReturn(1);
		$mockPagination->shouldReceive('from')->andReturn(1);
		return $mockPagination;
	}

    public function test_usecase(): void
    {
		$mockPagination = $this->mockPagination();

		$mockRepository = Mockery::mock(GenreRepositoryInterface::class);
		$mockRepository->shouldReceive('paginate')
			->with('teste', 'desc', 1, 15)
			->andReturn($mockPagination);
		$useCase = new ListGenresUseCase($mockRepository);

		$mockDtoInput = Mockery::mock(ListGenresInputDto::class,
		[
			'teste', 'desc', 1, 15
		]);

		$response = $useCase->execute($mockDtoInput);
		$this->assertInstanceOf(ListGenresOutputDto::class, $response);
    }

	

	protected function tearDown(): void
	{
		Mockery::close();
		parent::tearDown();
	}
}
