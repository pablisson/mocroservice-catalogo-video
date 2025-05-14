<?php

namespace Core\DTO\Genre\ListGenres;

use Core\Domain\Entity\Genre;

class ListGenresOutputDto
{
	public function __construct(
		/**
		 * @return stdClass[]|Genre[]|array
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