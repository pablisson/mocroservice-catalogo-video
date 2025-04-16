<?php

namespace Core\DTO\Category;

class CategoryCreateOutputDto
{
	public function __construct(
		public string $name,
		public string $id,
		public string $description = '',
		public bool $isActive = true,
	) {
	}


	public function toArray(): array
	{
		return [
			'name' => $this->name,
			'description' => $this->description,
			'isActive' => $this->isActive,
		];
	}
}