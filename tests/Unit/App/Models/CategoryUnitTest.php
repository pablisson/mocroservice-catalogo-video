<?php

namespace Tests\Unit\App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CategoryUnitTest extends ModelTesteCase
{
	protected function model(): Model {
		return new Category();
	}
	
    public function traits(): array
    {
		return [
			HasFactory::class,
			softDeletes::class,
		];
    }

	public function fillables(): array
	{
		return [
			'id',
			'name',
			'description',
			'is_active'
		];
	}

	public function casts(): array
	{
		return [
			'id' => 'string',
			'is_active' => 'boolean',
			'deleted_at' => 'datetime',
		];
	}
}
