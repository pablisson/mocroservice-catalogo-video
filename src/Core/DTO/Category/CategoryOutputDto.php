<?php

namespace Core\DTO\Category;

class CategoryOutputDto
{
	public function __construct(
		public string $id,
		public string $name,
		public string $description = '',
		public bool $is_active = true,
		public string $created_at = '',
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