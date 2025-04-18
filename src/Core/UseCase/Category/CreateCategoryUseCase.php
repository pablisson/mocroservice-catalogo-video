<?php

namespace Core\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\DTO\Category\CategoryInputDto;
use Core\DTO\Category\CategoryOutputDto;

class CreateCategoryUseCase
{
	public function __construct(
		protected CategoryRepositoryInterface $repository
	) {

	}

	public function execute(CategoryInputDto $inputDto): CategoryOutputDto
	{
		$category = new Category(
			name: $inputDto->name,
			description: $inputDto->description,
			isActive: $inputDto->isActive
		);

		$newCategory = $this->repository->insert($category);

		return new CategoryOutputDto(
			name: $newCategory->name,
			id: $newCategory->id,
			description: $newCategory->description,
			is_active: $newCategory->isActive
		);
	}

}