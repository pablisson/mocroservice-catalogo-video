<?php

namespace Core\Domain\Entity;

use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Validation\DomainValidation;
use Core\Domain\ValueObject\Uuid;

class Category
{
	//use Traits\MethodsMagicsTrait;
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
		protected bool $isActive = true
	) {
		$this->id = $this->id ? new Uuid($this->id) : Uuid::random();
		$this->validate();
	}
		
	public function id(): string
	{
		return $this->id;
	}

	public function name(): string
	{
		return $this->name;
	}

	public function description(): string
	{
		return $this->description;
	}

	public function isActive(): bool
	{
		return $this->isActive;
	}

	public function activate(): void 
	{
		$this->isActive = true;
	}

	public function deactivate(): void 
	{
		$this->isActive = false;
	}
	
	public function update(string $name, string $description): void
	{
		$this->name = $name;
		$this->description = $description;
	}

	public function validate(): void
	{
		DomainValidation::str_max_length($this->name);
		DomainValidation::str_min_length($this->name);
		DomainValidation::str_can_null_and_max_length($this->description);
		
	}
		

}