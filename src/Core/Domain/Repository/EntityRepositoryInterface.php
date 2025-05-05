<?php

namespace Core\Domain\Repository;

/**
 * @template T
 */
interface EntityRepositoryInterface
{
	/**
	 * @param T $entity
	 * @return T|null
	 */
	public function insert($entity);

	/**
	 * @param string $id
	 * @return T|null
	 */
	public function findById(string $id);
	
	/**
	 * @param T $entity
	 * @return T|null
	 */
	public function update($entity);

	/**
	 * @param object $data
	 * @return T|null
	 */
	public function toCategory(object $data);
	public function findAll(string $filter = '', String $order='DESC'): array;
	public function paginate(string $filter = '', string $order='DESC', int $page = 1, int $totalPage = 15): PaginationInterface;
	public function delete(string $id): bool;
}