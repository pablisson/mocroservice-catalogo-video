<?php

namespace App\Repositories\Eloquent;

use App\Models\Category as ModelCategory;
use App\Repositories\Presenters\PaginationPresenter;
use Core\Domain\Entity\Category as EntityCategory;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
	public function __construct(protected ModelCategory $model)
	{
	}
	
	public function insert($entity): EntityCategory
	{
		$categoryModel = $this->model->create([
			'id' => $entity->id(),
			'name' => $entity->name,
			'description' => $entity->description,
			'is_active' => $entity->isActive,
			'created_at' => $entity->createdAt(),
		]);

		return $this->toCategory($categoryModel);
	}

	public function findById(string $id): ?EntityCategory
	{
		$categoryModel = $this->model->find($id);
		if (!$categoryModel) {
			throw new NotFoundException("Category id: {$id} not found");
		}
		
		return $this->toCategory($categoryModel);
	}

	public function getIdsListIds(array $categoriesId = []):array
	{		
		return $this->model
					->whereIn('id', $categoriesId)
					->get()
					->pluck('id')
					->toArray();
	}

	public function findAll(string $filter = '', $order='DESC'): array
	{
		$categories = $this->model
			->where(function($query) use ($filter){
				if ($filter) {
					$query->where('name', 'LIKE', "%{$filter}%");
				}
			})
			->orderBy('created_at', $order)
			->get();
			
		if ($categories->isEmpty()) {
			return [];
		}
 
		return $categories->toArray();
	}

	public function paginate(string $filter = '', string $order='DESC', int $page = 1, int $totalPage = 15): PaginationInterface
	{
		$query = $this->model;
		if ($filter) {
			$query->where('name', 'LIKE', "%{$filter}%");
		}
		$query->orderBy('created_at', $order);
		$paginator = $query->paginate();
		
		return new PaginationPresenter($paginator);
	}

	public function update($entity): EntityCategory
	{
		$categoryModel = $this->model->find($entity->id());
		if (!$categoryModel) {
			throw new NotFoundException("Category id: {$entity->id()} not found");
		}

		$categoryModel->update([
			'name' => $entity->name,
			'description' => $entity->description,
			'is_active' => $entity->isActive,
			'updated_at' => $entity->updatedAt,
		]);

		$categoryModel->refresh();

		return $this->toCategory($categoryModel);
	}

	public function delete(string $id): bool
	{
		$categoryModel = $this->model->find($id);
		if (!$categoryModel) {
			throw new NotFoundException("Category id: {$id} not found");
		}

		return $categoryModel->delete();
	}

	public function toCategory(object $object): EntityCategory
	{
		$entity = new EntityCategory(
			id: $object->id,
			name: $object->name,
			description: $object->description,
		);
		(bool) $object->is_active ? $entity->activate() : $entity->deactivate();
		return $entity;
	}
}