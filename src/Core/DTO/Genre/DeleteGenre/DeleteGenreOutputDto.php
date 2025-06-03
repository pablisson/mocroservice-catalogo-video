<?php

namespace Core\DTO\Genre\DeleteGenre;

class DeleteGenreOutputDto
{
	public function __construct(
		public string $id,
		public string $name,
		public string $description = '',
		public bool $is_active = true,
		public string $created_at = '',
		public string | null $deleted_at = '',
	) {
	}
}