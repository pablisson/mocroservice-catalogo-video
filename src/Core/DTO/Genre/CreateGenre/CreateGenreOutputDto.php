<?php

namespace Core\DTO\Genre\CreateGenre;

class CreateGenreOutputDto
{
	public function __construct(
		public string $id,
		public string $name,
		public bool $is_active = true,
		public ?string $created_at = null,
	) {
	}

}