<?php

namespace Core\DTO\Category\DeleteCategories;

class DeleteCategoryOutputDto
{
	public function __construct(
		public string $id,
		public string $name,
		public string $description = '',
		public bool $is_active = true,
		public string $created_at = '',
		public string $deleted_at = '',
	) {
	}
}