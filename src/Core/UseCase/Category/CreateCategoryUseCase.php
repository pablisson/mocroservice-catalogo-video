<?php

namespace Core\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;

class CreateCategoryUseCase
{
	public function __construct(
		protected CategoryRepositoryInterface $repository
	) {
	}

	public function execute()
	{
		$category = new Category(
			name: 'Category 1',
			description: 'Description 1',
			isActive: true
		);
		$this->repository->insert($category);

	}
}