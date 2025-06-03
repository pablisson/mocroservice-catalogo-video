<?php

namespace Core\UseCase\Genre;

use Core\Domain\Entity\Genre;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\GenreRepositoryInterface;
use Core\DTO\Genre\UpdateGenre\UpdateGenreInputDto;
use Core\DTO\Genre\UpdateGenre\UpdateGenreOutputDto;
use Core\UseCase\Interfaces\DatabaseTransactionInterface;

class UpdateGenreUseCase 
{
	public function __construct(
		protected GenreRepositoryInterface $repository,
		protected DatabaseTransactionInterface $transaction,
		protected CategoryRepositoryInterface $categoryRepository
	)
	{
		
	}

	public function execute (UpdateGenreInputDto $inputDto):UpdateGenreOutputDto
	{
		try {
			$genre = $this->repository->findById($inputDto->id);
			$genre->update(
				name: $inputDto->name,
			);
			foreach($inputDto->categoriesId as $categoryId){
				$genre->addCategory($categoryId);
			}

			$this->validateCategoryId($inputDto->categoriesId);

			$newGenre = $this->repository->update($genre);

			$this->transaction->commit();

			return new UpdateGenreOutputDto(
				id: (string) $newGenre->id(),
				name: $newGenre->name,
				is_active: $newGenre->isActive,
				created_at: $newGenre->createdAt(),
			);
			
		}catch (\Throwable $th){
			$this->transaction->rollback();
			throw $th;
		}
	}

	public function validateCategoryId(array $categoriesId = [])
	{
		$categoriesDb = $this->categoryRepository->getIdsListIds($categoriesId);

		$arrayDiff = array_diff($categoriesId, $categoriesDb);

		if(count($arrayDiff)){
			$message = sprintf(
				'%s %s not found',
				count($arrayDiff) > 1 ? 'Categories' : 'Category',
				implode(', ',$arrayDiff)
			);
			throw new NotFoundException($message);
		}

	}
}