<?php

namespace Core\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\DTO\Category\CategoryOutputDto;
use Core\DTO\Category\DeleteCategories\DeleteCategoriesInputDto;
use Core\DTO\Category\DeleteCategories\DeleteCategoriesOutputDto;

class DeleteCategoryUseCase
{
	public function __construct(
		protected CategoryRepositoryInterface $repository
	) {

	}

	public function execute(DeleteCategoriesInputDto $inputDto): DeleteCategoriesOutputDto
	{
		$category = $this->repository->findById($inputDto->id);
		// if (!$category) {
		// 	throw new \Exception('Category not found');
		// }

		$wasDeleted = $this->repository->delete($inputDto->id);

		if(!$wasDeleted) {
			throw new \Exception('Error deleting category');
		}

		return new DeleteCategoriesOutputDto(
				id: $category->id(),
				name: $category->name,
				description: $category->description,
				is_active: $category->isActive,
				created_at: $category->createdAt(),
				deleted_at: $category->deletedAt(),
			);
	}

}