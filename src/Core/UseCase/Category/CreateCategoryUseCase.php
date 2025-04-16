<?php

namespace Core\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\DTO\Category\CategoryCreateInputDto;
use Core\DTO\Category\CategoryCreateOutputDto;

class CreateCategoryUseCase
{
	public function __construct(
		protected CategoryRepositoryInterface $repository
	) {

	}

	public function execute(CategoryCreateInputDto $inputDto): CategoryCreateOutputDto
	{
		$category = new Category(
			name: $inputDto->name,
			description: $inputDto->description,
			isActive: $inputDto->isActive
		);

		$newCategory = $this->repository->insert($category);

		return new CategoryCreateOutputDto(
			name: $newCategory->name,
			id: $newCategory->id,
			description: $newCategory->description,
			isActive: $newCategory->isActive
		);
	}

}