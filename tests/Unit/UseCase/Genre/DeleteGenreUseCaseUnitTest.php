<?php

namespace Tests\Unit\UseCase\Genre;

use Core\Domain\Entity\Genre as EntityGenre;
use Core\Domain\Repository\GenreRepositoryInterface;
use Core\Domain\ValueObject\Uuid as ValueObjectUuid;
use Core\DTO\Genre\DeleteGenre\DeleteGenreOutputDto;
use Core\DTO\Genre\GenreInputDto;
use Core\UseCase\Genre\DeleteGenreUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class DeleteGenreUseCaseUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_delete(): void
    {
		$uuid = Uuid::uuid4()->toString();

		$genreEntity = new EntityGenre(
			name: 'teste',
			id: new ValueObjectUuid($uuid), 

		);
		$mockRepository = Mockery::mock(GenreRepositoryInterface::class);
		$mockRepository->shouldReceive('findById')->andReturn($genreEntity);
		$mockRepository->shouldReceive('delete')->with($uuid)->andReturn(true);

		
		$mockInputDto = Mockery::mock(GenreInputDto::class,[
			$uuid
		]);

		$useCase = new DeleteGenreUseCase($mockRepository);
		$response = $useCase->execute($mockInputDto);

		$this->assertInstanceOf(DeleteGenreOutputDto::class, $response);		
		$this->assertNotContainsEquals($response->deleted_at, [null, '']);
    }

	public function test_delete_fail(): void
    {
		// nesse caso poderia usar o try catch, que poderia ajudar a pegar algo 
		// mais generico e amplo, porém como é uma exceção esperada, 
		// vou usar o expectException
		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('Error deleting genre');
		
		$uuid = Uuid::uuid4()->toString();

		$genreEntity = new EntityGenre(
			name: 'teste',
			id: new ValueObjectUuid($uuid), 
			deletedAt: null

		);
		$mockRepository = Mockery::mock(GenreRepositoryInterface::class);
		$mockRepository->shouldReceive('findById')->andReturn($genreEntity);
		$mockRepository->shouldReceive('delete')->with($uuid)->andReturn(false);

		$mockInputDto = Mockery::mock(GenreInputDto::class,[
			$uuid
		]);

		$useCase = new DeleteGenreUseCase($mockRepository);
		$useCase->execute($mockInputDto);
    }
}
