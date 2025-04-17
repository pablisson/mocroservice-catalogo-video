<?php

namespace Core\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\DTO\Category\CategoryInputDto;
use Core\DTO\Category\CategoryOutputDto;

class UpdateCategoryUseCase
{
	public function __construct(
		protected CategoryRepositoryInterface $repository
	) {

	}

	public function execute(CategoryInputDto $inputDto): CategoryOutputDto
	{
		$category = $this->repository->findById($inputDto->id);
		// if (!$category) {
		// 	throw new \Exception('Category not found');
		// }

		$category->update(
			name: $inputDto->name ?? $category->name,
			description: $inputDto->description ?? $category->description
		);

		$categoryUpdated = $this->repository->update($category);

		return new CategoryOutputDto(
			name: $categoryUpdated->name,
			id: $categoryUpdated->id,
			description: $categoryUpdated->description,
			is_active: $categoryUpdated->isActive
		);
	}

}