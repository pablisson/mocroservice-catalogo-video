<?php

namespace Core\DTO\Genre;

class GenreInputDto
{
	public function __construct(
		public string $id = '',
		public string $name = '',
		public string $description = '',
		public bool $isActive = true,
		
	) {
	}

}