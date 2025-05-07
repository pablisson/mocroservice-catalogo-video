<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Core\DTO\Category\CategoryInputDto;
use Core\DTO\Category\CreateCategory\CreateCategoryInputDto;
use Core\DTO\Category\ListCategories\ListCategoriesInputDto;
use Core\UseCase\Category\CreateCategoryUseCase;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\Category\ListCategoryUseCase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    //
	public function index(Request $request, ListCategoriesUseCase $useCase)
	{

		$response = $useCase->execute(
			input: new ListCategoriesInputDto(
				filter: $request->get('filter',''),
				order: $request->get('order', 'DESC'),
				page: (int)$request->get('page', 1),
				totalPage: (int)$request->get('total_page')
			)
		);
		
		return CategoryResource::collection(collect($response->items))
			->additional([
				'meta' => [
					'total' => $response->total,
					'last_page' => $response->last_page,
					'first_page' => $response->first_page,
					'current_page' => $response->current_page,
					'per_page' => $response->per_page,
					'from' => $response->from,
					'to' => $response->to,
				]
			]);

	}

	public function store(StoreCategoryRequest $request, CreateCategoryUseCase $useCase)
	{
		$response =$useCase->execute(
			inputDto: new CreateCategoryInputDto(
				name: $request->name ?? '',
				description: $request->description ?? '',
				
			)
		);
		return (new CategoryResource(collect($response)))
			->response()
			->setStatusCode(Response::HTTP_CREATED);
	}
	/**
	 * TODO: A principio deixarei passando o $id para em um segundo momento atualizar para o padrão
	 * do laravel de trazer a model automaticamente
	 */
	public function show(ListCategoryUseCase $useCase,  $id)
	{
		$response = $useCase->execute(
			input: new CategoryInputDto(id: $id)
		);
		
		return (new CategoryResource(collect($response)))
			->response()
			->setStatusCode(Response::HTTP_OK);
	}

}
