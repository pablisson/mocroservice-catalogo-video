<?php

namespace Core\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\DTO\Category\CategoryInputDto;
use Core\DTO\Category\CategoryOutputDto;

class FindByIdCategoryUseCase
{
	public function __construct(
		protected CategoryRepositoryInterface $repository
	) {

	}

	public function execute(CategoryInputDto $inputDto): CategoryOutputDto
	{
		$newCategory = $this->repository->findById($inputDto->id);

		return new CategoryOutputDto(
			id: $newCategory->id,
			name: $newCategory->name,
			description: $newCategory->description,
			is_active: $newCategory->isActive
		);
	}

}