<?php

namespace Tests\Unit\UseCase\Genre;

use Core\Domain\Entity\Genre as EntityGenre;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\GenreRepositoryInterface;
use Core\Domain\ValueObject\Uuid as ValueObjectUuid;
use Core\DTO\Genre\CreateGenre\CreateGenreInputDto;
use Core\DTO\Genre\CreateGenre\CreateGenreOutputDto;
use Core\UseCase\Genre\CreateGenreUseCase;
use Core\UseCase\Interfaces\DatabaseTransactionInterface;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateGenreUseCaseUnitTest extends TestCase
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

    public function test_create(): void
    {

		$mockRepository = Mockery::mock(GenreRepositoryInterface::class);
		$mockRepository->shouldReceive('insert')->andReturn($this->genreEntity);		

		$mockInputDto = Mockery::mock(CreateGenreInputDto::class,[
			$this->name, [$this->uuidCategory], true
		]);

		$mockCategoryRepository = Mockery::mock(CategoryRepositoryInterface::class);
		$mockCategoryRepository->shouldReceive('getIdsListIds')->andReturn([$this->uuidCategory]);

		$mockDbTransaction = Mockery::mock(DatabaseTransactionInterface::class);
		$mockDbTransaction->shouldReceive('commit');
		$mockDbTransaction->shouldReceive('rollback');

		$useCase = new CreateGenreUseCase($mockRepository, $mockDbTransaction, $mockCategoryRepository);
		$response = $useCase->execute($mockInputDto);

		$this->assertInstanceOf(CreateGenreOutputDto::class, $response);
    }

	public function test_create_categories_notfound(): void
    {
		$this->expectException(NotFoundException::class);
		

		$mockRepository = Mockery::mock(GenreRepositoryInterface::class);
		$mockRepository->shouldReceive('insert')->andReturn($this->genreEntity);		

		$mockInputDto = Mockery::mock(CreateGenreInputDto::class,[
			$this->name, [$this->uuidCategory, 'fake_id', 'new_fake_id'], true
		]);

		$mockCategoryRepository = Mockery::mock(CategoryRepositoryInterface::class);
	
		$mockCategoryRepository->shouldReceive('getIdsListIds')->andReturn([$this->uuidCategory]);
		$mockDbTransaction = Mockery::mock(DatabaseTransactionInterface::class);
		$mockDbTransaction->shouldReceive('commit');
		$mockDbTransaction->shouldReceive('rollback');

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
