<?php

namespace Core\DTO\Category;

class CategoryInputDto
{
	public function __construct(
		public string $id = '',
		public string $name = '',
		public string $description = '',
		public bool $isActive = true,
		
	) {
	}

}