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
		protected array $categoriesId = [],
	) {
		$this->id = $this->id ?? Uuid::random();
		$this->createdAt = $this->createdAt ?? new DateTime();
		$this->validate();
	}

	public function addCategory(string $categoryId): void
	{
		if(!in_array($categoryId, $this->categoriesId)) {
			array_push($this->categoriesId, $categoryId);			
		}
	}

	public function categoriesId(): array
	{
		return $this->categoriesId;
	}


}