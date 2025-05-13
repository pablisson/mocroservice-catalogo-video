<?php

namespace Core\Domain\Entity;

use Core\Domain\Entity\Traits\EntityBase;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Validation\DomainValidation;
use Core\Domain\ValueObject\Uuid;
use DateTime;

class Genre
{
	use Traits\MethodsMagicsTrait, EntityBase;

	public array $categoriesId = [];
	/**
	 * @param string $id
	 * @param string $name
	 * @param string $description
	 * @param bool $isActive
	 */
	public function __construct(
		protected string $name,
		protected ?Uuid $id = null,
		protected string $description = '',
		protected bool $isActive = true,
		protected ?DateTime $createdAt = null,
		protected ?DateTime $deletedAt = null,
		protected ?DateTime $updatedAt = null,
	) {
		$this->id = $this->id ?? Uuid::random();
		$this->createdAt = $this->createdAt ?? new DateTime();
		$this->validate();
	}

	public function addCategory(string $categoryId): void
	{
		// if ($this->hasCategory($categoryId)) {
		// 	throw new EntityValidationException('A categoria já está associada a este gênero.');
		// }

		array_push($this->categoriesId, $categoryId);
		
	}

}