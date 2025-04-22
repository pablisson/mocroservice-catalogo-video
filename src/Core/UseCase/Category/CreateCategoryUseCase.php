<?php

namespace Core\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\DTO\Category\CreateCategory\CreateCategoryInputDto;
use Core\DTO\Category\CreateCategory\CreateCategoryOutputDto;

class CreateCategoryUseCase
{
	public function __construct(
		protected CategoryRepositoryInterface $repository
	) {

	}

	public function execute(CreateCategoryInputDto $inputDto): CreateCategoryOutputDto
	{
		$category = new Category(
			name: $inputDto->name,
			description: $inputDto->description,
			isActive: $inputDto->isActive
		);

		$newCategory = $this->repository->insert($category);

		return new CreateCategoryOutputDto(
			name: $newCategory->name,
			id: $newCategory->id,
			description: $newCategory->description,
			is_active: $newCategory->isActive,
			created_at: $newCategory->createdAt(),
		);
	}

}