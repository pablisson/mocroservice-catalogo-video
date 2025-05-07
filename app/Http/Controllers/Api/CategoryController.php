<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\Category\ListCategoryUseCase;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
	public function index(Request $request, ListCategoriesUseCase $useCase)
	{
		// return response()->json(['message' => 'Hello World']);
		//return response()->json(['message' => 'Hello World']);
	}
}
