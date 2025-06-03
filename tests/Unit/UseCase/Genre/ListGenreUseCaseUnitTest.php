<?php

namespace Tests\Unit\UseCase\Genre;

use Core\Domain\Entity\Genre as EntityGenre;
use Core\Domain\Repository\GenreRepositoryInterface;
use Core\Domain\ValueObject\Uuid as ValueObjectUuid;
use Core\DTO\Genre\GenreInputDto;
use Core\DTO\Genre\GenreOutputDto;
use Core\UseCase\Genre\ListGenreUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class ListGenreUseCaseUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_list_single(): void
    {
		$uuid = Uuid::uuid4()->toString();

		$genreEntity = new EntityGenre(
			name: 'teste',
			id: new ValueObjectUuid($uuid), 

		);
		$mockRepository = Mockery::mock(GenreRepositoryInterface::class);
		$mockRepository->shouldReceive('findById')->andReturn($genreEntity);

		$mockInputDto = Mockery::mock(GenreInputDto::class,[
			$uuid
		]);

		$useCase = new ListGenreUseCase($mockRepository);
		$response = $useCase->execute($mockInputDto);

		$this->assertInstanceOf(GenreOutputDto::class, $response);
    }
}
