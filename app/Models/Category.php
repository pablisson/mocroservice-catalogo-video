<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes;
	protected $fillable = [
		'id',
		'name',
		'description',
		'is_active'
	];

	public $incrementing = false;

	protected $casts = [
		'id' => 'string',
		'is_active' => 'boolean',
		'deleted_at' => 'datetime',
	];
}
