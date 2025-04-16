<?php

namespace Core\DTO\Category;

class CategoryCreateInputDto
{
	public function __construct(
		public string $name = '',
		public string $description = '',
		public bool $isActive = true,
	) {
	}

}