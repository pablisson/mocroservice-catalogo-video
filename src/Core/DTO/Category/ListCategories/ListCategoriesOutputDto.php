<?php

namespace Core\DTO\Category\ListCategories;

use Core\Domain\Entity\Category;

class ListCategoriesOutputDto
{
	public function __construct(
		/**
		 * @return stdClass[]|Category[]
		 */
		public array $items,	
		public int $total,
		public int $last_page,
		public int $first_page,
		public int $current_page,
		public int $per_page,
		public int $to,	
		public int $from
	) {

	}
}