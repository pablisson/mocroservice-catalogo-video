<?php

namespace Core\Domain\Entity;

use Core\Domain\Entity\Traits\EntityBase;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Validation\DomainValidation;
use Core\Domain\ValueObject\Uuid;
use DateTime;

class Category
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
		protected Uuid | string $id = '',
		protected string $description = '',
		protected bool $isActive = true,
		protected DateTime|string $createdAt = '',
		protected DateTime|string $deletedAt = '',
		protected DateTime|string $updatedAt = '',
	) {
		$this->id = $this->id ? (new Uuid($this->id))->uuid() : Uuid::random();
		$this->createdAt = $this->createdAt ? new DateTime($this->createdAt) : new DateTime();
		$this->validate();
	}

}