<?php

namespace Core\Domain\Entity\Traits;

trait MethodsMagicsTrait
{
	public function __get($property)
	{
		if (property_exists($this, $property)) {
			return $this->$property;
		}

		$className = get_class($this);
		$className = str_replace('Core\\', '', $className);
		throw new \InvalidArgumentException("A propriedade {$property} não existe na classe {$className}.");
	}
}