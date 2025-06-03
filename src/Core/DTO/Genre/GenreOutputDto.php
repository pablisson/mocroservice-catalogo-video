<?php

namespace Core\DTO\Genre;

class GenreOutputDto
{
	public function __construct(
		public string $id,
		public string $name,
		public string $description = '',
		public bool $is_active = true,
		public ?string $created_at = null,
		public ?string $updated_at = null,
		public ?string $deleted_at = null,
	) {
	}


	public function toArray(): array
	{
		return [
			'name' => $this->name,
			'description' => $this->description,
			'isActive' => $this->is_active,
		];
	}
}