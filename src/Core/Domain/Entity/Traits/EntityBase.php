<?php

namespace Core\Domain\Entity\Traits;

use Core\Domain\Validation\DomainValidation;
use DateTime;

trait EntityBase
{
	public function deactivate(): void 
	{
		$this->isActive = false;
	}

	public function activate(): void 
	{
		$this->isActive = true;
	}

	public function update(string $name, string $description): void
	{
		$this->name = $name;
		$this->description = $description;
	}

	public function delete(): void
	{
		$this->deletedAt = new DateTime();
	}

	private function validate(): void
	{
		DomainValidation::str_max_length($this->name);
		DomainValidation::str_min_length($this->name);
		DomainValidation::str_can_null_and_max_length($this->description);
		
	}
}