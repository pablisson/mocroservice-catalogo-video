<?php

namespace Core\UseCase\Genre;

use Core\Domain\Entity\Genre;
use Core\Domain\Repository\GenreRepositoryInterface;
use Core\DTO\Genre\GenreInputDto;
use Core\DTO\Genre\GenreOutputDto;

class CreateGenreUseCase
{
	
	public function __construct(
		protected GenreRepositoryInterface $repository
		)
	{
		
	}

	public function execute(GenreInputDto $inputDto): GenreOutputDto
	{
		$genre = new Genre(
			name: $inputDto->name,
			description: $inputDto->description,
			isActive: $inputDto->isActive
		);

		$newGenre = $this->repository->insert($genre);
		
		return new GenreOutputDto(
			id: $newGenre->id(),
			name: $newGenre->name,
			description: $newGenre->description,
			is_active: $newGenre->isActive,
			created_at: $newGenre->createdAt(),
			deleted_at: $newGenre->deletedAt()
		);
	}
	

}
