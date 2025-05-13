<?php

namespace Core\Domain\Entity;

use Core\Domain\ValueObject\Uuid;
use DateTime;

class Genre
{
	use Traits\MethodsMagicsTrait;
	/**
	 * @param string $id
	 * @param string $name
	 * @param string $description
	 * @param bool $isActive
	 */
	public function __construct(
		protected Uuid | null $id = null,
		protected string $name,
		protected string $description = '',
		protected bool $isActive = true,
		protected DateTime|null $createdAt = null,
		protected DateTime|null $deletedAt = null,
		protected DateTime|null $updatedAt = null,
	) {
		$this->id = $this->id ?? Uuid::random();
		$this->createdAt = $this->createdAt ?? new DateTime();
	}
}