<?php

namespace Core\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\DTO\Category\UpdateCategory\UpdateCategoryInputDto;
use Core\DTO\Category\UpdateCategory\UpdateCategoryOutputDto;

class UpdateCategoryUseCase
{
	public function __construct(
		protected CategoryRepositoryInterface $repository
	) {

	}

	public function execute(UpdateCategoryInputDto $inputDto): UpdateCategoryOutputDto	
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

		return new UpdateCategoryOutputDto(
			name: $categoryUpdated->name,
			id: $categoryUpdated->id,
			description: $categoryUpdated->description,
			is_active: $categoryUpdated->isActive
		);
	}

}