<?php

namespace Core\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\DTO\Category\DeleteCategories\DeleteCategoryInputDto;
use Core\DTO\Category\DeleteCategories\DeleteCategoryOutputDto;
use DateTime;

class DeleteCategoryUseCase 
{
	public function __construct(
		protected CategoryRepositoryInterface $repository
	) {

	}

	public function execute(DeleteCategoryInputDto $inputDto): DeleteCategoryOutputDto
	{
		
		$category = $this->repository->findById($inputDto->id);
		
		if (!$category) {
			throw new \Exception('Category not found');
		}
		
		$dateNow = new DateTime();

		$wasDeleted = $this->repository->delete($inputDto->id);
		
		if(!$wasDeleted) {
			throw new \Exception('Error deleting category');
		}

		$deleteCategoriesOutputDto = new DeleteCategoryOutputDto(
			id: $category->id ?? $inputDto->id,
			name: $category->name ?? $inputDto->name,
			description: $category->description ?? $inputDto->description,
			is_active: $category->isActive ?? $inputDto->isActive,
			created_at: isset($category->createdAt)
				? $category->createdAt->format('Y-m-d H:i:s')
				: $dateNow->format('Y-m-d H:i:s'),
			deleted_at: isset($category->deletedAt)
				? $category->deletedAt->format('Y-m-d H:i:s')
				: $dateNow->format('Y-m-d H:i:s'),
		);
		return $deleteCategoriesOutputDto;
	}
}