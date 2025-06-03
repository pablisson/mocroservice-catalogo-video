<?php

namespace Tests\Unit\UseCase\Genre;

use Core\Domain\Entity\Genre as EntityGenre;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\GenreRepositoryInterface;
use Core\Domain\ValueObject\Uuid as ValueObjectUuid;
use Core\DTO\Genre\UpdateGenre\UpdateGenreInputDto;
use Core\DTO\Genre\UpdateGenre\UpdateGenreOutputDto;
use Core\UseCase\Genre\UpdateGenreUseCase;
use Core\UseCase\Interfaces\DatabaseTransactionInterface;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UpdateGenreUseCaseUnitTest extends TestCase
{
	private EntityGenre $genreEntity;
	private string $uuid;
	private string $name;
	private string $uuidCategory;

	protected function setUp(): void
	{
		$this->uuid = Uuid::uuid4()->toString();
		$this->uuidCategory = Uuid::uuid4()->toString();
		$this->name = 'teste';

		$this->genreEntity = new EntityGenre(
			name: $this->name,
			id: new ValueObjectUuid($this->uuid), 
		);
	}

    public function test_update(): void
    {
		$newName = "name updated";
		$newUuid = Uuid::uuid4()->toString();
		$newGenre = new EntityGenre(
			name: $newName,
			id: new ValueObjectUuid($this->uuid)
		);

		$mockRepository = Mockery::mock(GenreRepositoryInterface::class);
		$mockRepository->shouldReceive('update')->andReturn($newGenre);		
		$mockRepository->shouldReceive('findById')->andReturn($this->genreEntity);

		$mockInputDto = Mockery::mock(UpdateGenreInputDto::class,[
			$this->uuid, $this->name, [$this->uuidCategory], true
		]);

		$mockCategoryRepository = Mockery::mock(CategoryRepositoryInterface::class);
		$mockCategoryRepository->shouldReceive('getIdsListIds')->andReturn([$this->uuidCategory]);

		$mockDbTransaction = Mockery::mock(DatabaseTransactionInterface::class);
		$mockDbTransaction->shouldReceive('commit');
		$mockDbTransaction->shouldReceive('rollback');

		$useCase = new UpdateGenreUseCase($mockRepository, $mockDbTransaction, $mockCategoryRepository);
		$response = $useCase->execute($mockInputDto);

		$this->assertInstanceOf(UpdateGenreOutputDto::class, $response);
    }

	public function test_update_categories_notfound(): void
    {
		$this->expectException(NotFoundException::class);

		$newName = "name updated";
		$newUuid = Uuid::uuid4()->toString();
		$newGenre = new EntityGenre(
			name: $newName,
			id: new ValueObjectUuid($this->uuid)
		);
		$mockRepository = Mockery::mock(GenreRepositoryInterface::class);
		$mockRepository->shouldReceive('insert')->andReturn($newGenre);		
		$mockRepository->shouldReceive('findById')->andReturn($this->genreEntity);

		$mockInputDto = Mockery::mock(UpdateGenreInputDto::class,[
			$this->uuid, $this->name, [$this->uuidCategory,'fake-uuid'], true
		]);

		$mockCategoryRepository = Mockery::mock(CategoryRepositoryInterface::class);
	
		$mockCategoryRepository->shouldReceive('getIdsListIds')->andReturn([$this->uuidCategory]);
		$mockDbTransaction = Mockery::mock(DatabaseTransactionInterface::class);
		$mockDbTransaction->shouldReceive('commit');
		$mockDbTransaction->shouldReceive('rollback');

		$useCase = new UpdateGenreUseCase($mockRepository, $mockDbTransaction, $mockCategoryRepository);
		$response = $useCase->execute($mockInputDto);

		$this->assertInstanceOf(UpdateGenreOutputDto::class, $response);
    }

	protected function tearDown(): void
	{
		Mockery::close();
		parent::tearDown();
	}
}
