<?php

namespace Tests\Unit\UseCase\Genre;

use Core\Domain\Entity\Genre as EntityGenre;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\GenreRepositoryInterface;
use Core\Domain\ValueObject\Uuid as ValueObjectUuid;
use Core\DTO\Genre\CreateGenreInputDto;
use Core\DTO\Genre\CreateGenreOutputDto;
use Core\UseCase\Genre\CreateGenreUseCase;
use Core\UseCase\Interfaces\DatabaseTransactionInterface;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateGenreUseCaseUnitTest extends TestCase
{

    public function test_create(): void
    {

		$uuid = Uuid::uuid4()->toString();
		$name = 'teste';

		$genreEntity = new EntityGenre(
			name: $name,
			id: new ValueObjectUuid($uuid), 

		);
		$mockRepository = Mockery::mock(GenreRepositoryInterface::class);
		$mockRepository->shouldReceive('insert')->andReturn($genreEntity);

		$mockInputDto = Mockery::mock(CreateGenreInputDto::class,[
			$uuid,
			$name,
		]);

		$mockCategoryRepository = Mockery::mock(CategoryRepositoryInterface::class);
		$mockDbTransaction = Mockery::mock(DatabaseTransactionInterface::class);

		$useCase = new CreateGenreUseCase($mockRepository, $mockDbTransaction, $mockCategoryRepository);
		$response = $useCase->execute($mockInputDto);

		$this->assertInstanceOf(CreateGenreOutputDto::class, $response);
    }

	protected function tearDown(): void
	{
		Mockery::close();
		parent::tearDown();
	}
}
