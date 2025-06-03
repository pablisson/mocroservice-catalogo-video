<?php

namespace Core\UseCase\Genre;

use Core\Domain\Repository\GenreRepositoryInterface;
use Core\DTO\Genre\DeleteGenre\DeleteGenreOutputDto;
use Core\DTO\Genre\GenreInputDto;
use DateTime;

class DeleteGenreUseCase
{
	
	public function __construct(
		protected GenreRepositoryInterface $repository
		)
	{
		
	}

	public function execute(GenreInputDto $inputDto): DeleteGenreOutputDto
	{
		$genre = $this->repository->findById($inputDto->id);
		
		$dateNow = new DateTime();

		$wasDeleted = $this->repository->delete($inputDto->id);
		
		if(!$wasDeleted) {
			throw new \Exception('Error deleting genre');
		}

		return new DeleteGenreOutputDto(
			id: $genre->id(),
			name: $genre->name,
			description: $genre->description,
			is_active: $genre->isActive,
			created_at: $genre->createdAt(),
			deleted_at:  isset($genre->deletedAt)
				? $genre->deletedAt->format('Y-m-d H:i:s')
				: $dateNow->format('Y-m-d H:i:s'),
		);
		
	}
	

}
