<?php

namespace Core\DTO\Category\DeleteCategories;

class DeleteCategoriesInputDto
{
	public function __construct(
		public string $id = '',
		public string $name = '',
		public string $description = '',
		public bool $isActive = true,
		
	) {
	}

}