<?php

namespace Core\DTO\Category\CreateCategory;

class CreateCategoryInputDto
{
	public function __construct(
		public string $id = '',
		public string $name = '',
		public string $description = '',
		public bool $isActive = true,
		
	) {
	}

}