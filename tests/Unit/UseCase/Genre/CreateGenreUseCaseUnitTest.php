<?php

namespace Tests\Unit\UseCase\Genre;

use Core\Domain\Entity\Genre as EntityGenre;
use Core\Domain\Repository\GenreRepositoryInterface;
use Core\Domain\ValueObject\Uuid as ValueObjectUuid;
use Core\DTO\Genre\GenreInputDto;
use Core\DTO\Genre\GenreOutputDto;
use Core\UseCase\Genre\CreateGenreUseCase;
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

		$mockInputDto = Mockery::mock(GenreInputDto::class,[
			$uuid,
			$name,
		]);

		$useCase = new CreateGenreUseCase($mockRepository);
		$response = $useCase->execute($mockInputDto);

		$this->assertInstanceOf(GenreOutputDto::class, $response);
    }

	protected function tearDown(): void
	{
		Mockery::close();
		parent::tearDown();
	}
}
