<?php

namespace Tests\Unit\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Validation\DomainValidation;
use PHPUnit\Framework\TestCase;

class DomainValidationUnitTest extends TestCase
{
	public function test_not_null()
	{
		try {
			$value = "";
			DomainValidation::notNull($value);
			$this->assertTrue(false);
		} catch (\Throwable $th) {
			$this->assertInstanceOf(EntityValidationException::class, $th);			
		}
	}

	public function test_not_null_custom_message_exception()
	{
		try {
			$value = "";
			DomainValidation::notNull($value, 'Custom message error');
			$this->assertTrue(false);
		} catch (\Throwable $th) {
			$this->assertInstanceOf(EntityValidationException::class, $th, 'Custom message error');
		}
	}

	public function test_str_max_length()
	{
		try {
			$value = "Teste";
			DomainValidation::str_max_length($value, 5, 'Custom message error');
			$this->assertTrue(false);
		} catch (\Throwable $th) {
			$this->assertInstanceOf(EntityValidationException::class, $th, 'Custom message error');			
		}
	}

	public function test_str_min_length()
	{
		try {
			$value = "Teste";
			DomainValidation::str_min_length($value, 6, '');
			$this->assertTrue(false);
		} catch (\Throwable $th) {			
			$this->assertInstanceOf(EntityValidationException::class, $th, '');			
		}
	}

	public function test_str_can_null_and_max_length()
	{
		try {
			$value = 'teste';
			DomainValidation::str_can_null_and_max_length($value, 5, 'Custom message error');
			$this->assertTrue(false);
		} catch (\Throwable $th) {
			$this->assertInstanceOf(EntityValidationException::class, $th, 'Custom message error');			
		}
	}

}