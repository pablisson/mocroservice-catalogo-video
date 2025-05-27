<?php

namespace Core\DTO\Genre\UpdateGenre;

class UpdateGenreInputDto
{
	public function __construct(
		public string $id,
		public string $name,
		public array $categoriesId = [],
		public bool $isActive = true,
		
	) {
	}

}