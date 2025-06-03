<?php

namespace Core\DTO\Genre\CreateGenre;

class CreateGenreInputDto
{
	public function __construct(
		public string $name,
		public array $categoriesId = [],
		public bool $isActive = true,
		
	) {
	}

}