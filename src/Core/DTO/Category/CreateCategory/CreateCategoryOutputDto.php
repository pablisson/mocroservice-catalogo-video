<?php

namespace Core\DTO\Category\CreateCategory;

class CreateCategoryOutputDto
{
	public function __construct(
		public string $id,
		public string $name,
		public string $description = '',
		public bool $is_active = true,
		public string $created_at = '',
		public string $updated_at = '',
		public string $deleted_at = '',
	) {
	}


	public function toArray(): array
	{
		return [
			'id' => $this->id,
			'name' => $this->name,
			'description' => $this->description,
			'isActive' => $this->is_active,
			'createdAt' => $this->created_at,			
			'updatedAt' => $this->updated_at,
			'deletedAt' => $this->deleted_at,
		];
	}
}