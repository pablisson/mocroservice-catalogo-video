<?php

namespace Core\Domain\Entity;

use Core\Domain\Entity\Traits\EntityBase;
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
	) {
		$this->id = $this->id ?? Uuid::random();
		$this->createdAt = $this->createdAt ?? new DateTime();
		$this->validate();
	}

}