<?php

namespace Tests\Unit\App\Models;

use App\Models\Category;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CategoryUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     */

	protected function model(): Model {
		return new Category();
	}
	
    public function teste_if_Use_Traits(): void
    {
		$traitsNeeded = [
			HasFactory::class,
			softDeletes::class,
		];
		
		$traitsUser = array_keys(class_uses($this->model()));

        $this->assertEquals($traitsNeeded, $traitsUser);
    }

	public function test_incrementing_is_false(): void
	{
		$this->assertFalse($this->model()->incrementing);
	}

	public function test_fillable_attributes(): void
	{
		$fillable = [
			'id',
			'name',
			'description',
			'is_active'
		];

		$this->assertEquals($fillable, $this->model()->getFillable());
	}

	public function test_casts_attributes(): void
	{
		$casts = [
			'id' => 'string',
			'is_active' => 'boolean',
			'deleted_at' => 'datetime',
		];

		$this->assertEquals($casts, $this->model()->getCasts());
	}
}
