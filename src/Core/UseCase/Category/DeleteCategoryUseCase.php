<?php

namespace Core\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\DTO\Category\CategoryOutputDto;
use Core\DTO\Category\DeleteCategories\DeleteCategoriesInputDto;
use Core\DTO\Category\DeleteCategories\DeleteCategoriesOutputDto;
use DateTime;
use Mockery;

class DeleteCategoryUseCase 
{
	public function __construct(
		protected CategoryRepositoryInterface $repository
	) {

	}

	public function execute(DeleteCategoriesInputDto $inputDto): DeleteCategoriesOutputDto
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

		$deleteCategoriesOutputDto = new DeleteCategoriesOutputDto(
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