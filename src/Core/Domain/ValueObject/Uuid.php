<?php

namespace Core\Domain\ValueObject;

use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
	public function __construct(
		protected string $value
	) {
		$this->ensureIsValid($value);
	}

	public static function random(): self
	{
		$uuid = RamseyUuid::uuid4()->toString();
		return new self($uuid);
	}

	public function __toString(): string
	{
		return $this->value;
	}

	private function ensureIsValid(string $value)
	{
		if (!RamseyUuid::isValid($value)){
			throw new \InvalidArgumentException("Invalid UUID: {$value}");
		}
	}
}