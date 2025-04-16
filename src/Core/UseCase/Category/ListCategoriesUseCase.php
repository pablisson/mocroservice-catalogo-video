<?php

namespace Core\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\DTO\Category\ListCategories\ListCategoriesInputDto;
use Core\DTO\Category\ListCategories\ListCategoriesOutputDto;

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
			items: (array) $categories->items()
		);	
	}
}