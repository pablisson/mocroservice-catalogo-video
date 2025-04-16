<?php

namespace Core\DTO\Category\ListCategories;

use Core\Domain\Entity\Category;

class ListCategoriesOutputDto
{
	public function __construct(
		public array $items = [],	
	) {

	}
}