<?php

namespace Core\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;

class DomainValidation
{
	/**
	 * @param string $value
	 * @param string $message
	 * @return void
	 * @throws EntityValidationException
	 */
	public static function notNull(string $value, string $message = ''): void
	{
		if (empty($value)) {
			throw new EntityValidationException(empty($message)?? "O valor não pode ser nulo");
		}
	}

	public static function str_max_length(string $value, int $length = 255, string $message=''): void
	{
		if (strlen($value) >= $length) {
			throw new EntityValidationException( empty($message) ??"O valor deve ser menor que {$length} caracteres");
		}
	}

	public static function str_min_length(string $value, int $length = 2, string $message=''): void
	{
		if (strlen($value) <= $length) {
			throw new EntityValidationException( empty($message)??"O valor deve ser maior que {$length} caracteres");
		}
	}

	public static function str_can_null_and_max_length(?string $value='', int $length = 255, string $message=''): void
	{
		if (!empty($value) && strlen($value) >= $length) {
			throw new EntityValidationException( empty($message)??"O valor deve ser menor que {$length} caracteres");
		}
	}


}