<?php

namespace Core\Domain\Entity;

use Core\Domain\Exception\EntityValidationException;

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
		protected string $id = '',
		protected string $description = '',
		protected bool $isActive = true
	) {

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
		if (empty($this->name)) {
			throw new EntityValidationException('Nome inválido');
		}
		if ((strlen($this->name) > 255 || strlen($this->name) < 3)) {
			throw new EntityValidationException('Nome precisa ser maior que 3 e menor que 255 caracteres');
		}		

		if (!empty($this->description) && (strlen($this->description) > 255 || strlen($this->description) < 3)) {
			throw new EntityValidationException('Descrição precisa ser maior que 3 e menor que 255 caracteres');
		}
		
	}
		

}