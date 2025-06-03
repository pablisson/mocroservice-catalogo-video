<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\Category;
/**
 * Manterei a interface concreta da categoria para uma possível expansão futura
 * além disso o uso dela em RepositoryServiceProvider ajuda na injeção de 
 * dependências.
 */


/**
 * @extends EntityRepositoryInterface<Category>
 */
interface CategoryRepositoryInterface extends EntityRepositoryInterface
{
	public function getIdsListIds(array $categoriesId = []):array;
}