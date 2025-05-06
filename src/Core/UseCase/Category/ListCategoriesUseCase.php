<?php

namespace Core\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\DTO\Category\ListCategories\ListCategoriesInputDto;
use Core\DTO\Category\ListCategories\ListCategoriesOutputDto;
use stdClass;

class ListCategoriesUseCase
{
	public function __construct(
		protected CategoryRepositoryInterface $repository
	) {
	}

	public function execute(ListCategoriesInputDto $input):ListCategoriesOutputDto{
		$categories = $this->repository->paginate(
			filter: $input->filter,
			order:  $input->order,
			page: $input->page,
			totalPage: $input->totalPage
		);

		return new ListCategoriesOutputDto(
			items: 	(array) $categories->items(),
			total: $categories->total(),
			last_page: $categories->lastPage(),
			first_page: $categories->firstPage(),
			current_page: $categories->currentPage(),
			per_page: $categories->perPage(),
			to: $categories->to(),
			from: $categories->from()
		);	

		// return new ListCategoriesOutputDto(
		// 	items: array_map(
		// 		fn($category) => new stdClass(
		// 			id: $category->id,
		// 			name: $category->name,
		// 			description: $category->description,
		// 			is_active: $category->isActive
		// 		),
		// 		$categories->items()
		// 	),
		// 	total: $categories->total(),
		// 	last_page: $categories->lastPage(),
		// 	first_page: $categories->firstPage(),
		// 	current_page: $categories->currentPage(),
		// 	per_page: $categories->perPage(),
		// 	to: $categories->to(),
		// 	from: $categories->from()
		// );	
		
	}
}