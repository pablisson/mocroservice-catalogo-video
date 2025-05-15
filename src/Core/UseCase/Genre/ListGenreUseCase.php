<?php

namespace Core\UseCase\Genre;

use Core\Domain\Repository\GenreRepositoryInterface;
use Core\DTO\Genre\GenreInputDto;
use Core\DTO\Genre\GenreOutputDto;

class ListGenreUseCase
{
	
	public function __construct(
		protected GenreRepositoryInterface $repository
		)
	{
		
	}

	public function execute(GenreInputDto $inputDto): GenreOutputDto
	{
		$genre = $this->repository->findById($inputDto->id);
		dump($genre->deletedAt());
		return new GenreOutputDto(
			id: $genre->id(),
			name: $genre->name,
			description: $genre->description,
			is_active: $genre->isActive,
			created_at: $genre->createdAt(),
			deleted_at: $genre->deletedAt()
		);
	}
	

}
