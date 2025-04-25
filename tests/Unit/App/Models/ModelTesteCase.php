<?php

namespace Tests\Unit\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\TestCase;

abstract class ModelTesteCase extends TestCase
{
	abstract protected function model(): Model;
	abstract protected function traits(): array;
	abstract protected function fillables(): array;
	abstract protected function casts(): array;

	public function teste_if_Use_Traits(): void
    {
		$traitsNeeded = $this->traits();

		$traitsUser = array_keys(class_uses($this->model()));

        $this->assertEquals($traitsNeeded, $traitsUser);
    }

	public function test_incrementing_is_false(): void
	{
		$this->assertFalse($this->model()->incrementing);
	}

	public function test_fillable_attributes(): void
	{
		$fillable = $this->fillables();

		$this->assertEquals($fillable, $this->model()->getFillable());
	}

	public function test_casts_attributes(): void
	{
		$casts = $this->casts();

		$this->assertEquals($casts, $this->model()->getCasts());
	}
}
