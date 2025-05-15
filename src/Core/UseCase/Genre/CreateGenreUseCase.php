<?php

namespace Core\UseCase\Genre;

use Core\Domain\Entity\Genre;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\GenreRepositoryInterface;
use Core\DTO\Genre\CreateGenre\CreateGenreInputDto;
use Core\DTO\Genre\CreateGenre\CreateGenreOutputDto;
use Core\UseCase\Interfaces\DatabaseTransactionInterface;

class CreateGenreUseCase
{
	
	public function __construct(
		protected GenreRepositoryInterface $repository,
		protected DatabaseTransactionInterface $dbTransaction,
		protected CategoryRepositoryInterface $categoryRepository
		)
	{
		
	}

	public function execute(CreateGenreInputDto $inputDto): CreateGenreOutputDto
	{
		try {
			$this->validateCategoryId($inputDto->categoriesId);

			$genre = new Genre(
				name: $inputDto->name,			
				isActive: $inputDto->isActive,
				categoriesId: $inputDto->categoriesId
			);

			$newGenre = $this->repository->insert($genre);
			
			return new CreateGenreOutputDto(
				id: (string) $newGenre->id(),
				name: $newGenre->name,
				is_active: $newGenre->isActive,
				created_at: $newGenre->createdAt(),
			);
			$this->dbTransaction->commit();
		}catch (\Throwable $th){
			$this->dbTransaction->rollback();
			throw $th;
		}
	}

	public function validateCategoryId(array $categoriesId = [])
	{
		$categoriesDb = $this->categoryRepository->getIdsListIds($categoriesId);

		if(count($categoriesDb) !== count($categoriesId)){
			throw new NotFoundException('Categories is different fom database');
		}
		foreach($categoriesId as $catetory){

		}
	}
	

}
