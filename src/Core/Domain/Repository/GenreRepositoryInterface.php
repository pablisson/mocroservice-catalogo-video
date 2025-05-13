<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\Genre;
/**
 * Manterei a interface concreta da genre para uma possível expansão futura
 * além disso o uso dela em RepositoryServiceProvider ajuda na injeção de 
 * dependências.
 */


/**
 * @extends EntityRepositoryInterface<Genre>
 */
interface GenreRepositoryInterface extends EntityRepositoryInterface
{

}