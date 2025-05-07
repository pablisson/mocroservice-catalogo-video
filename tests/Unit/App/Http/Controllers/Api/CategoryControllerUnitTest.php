<?php

namespace Tests\Unit\App\Http\Controllers\Api;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\Api\CategoryController;
use Core\DTO\Category\ListCategories\ListCategoriesOutputDto;
use Core\UseCase\Category\ListCategoriesUseCase;
use Illuminate\Http\Request;
use Mockery;

class CategoryControllerUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_index(): void
    {
		$mockRequest = Mockery::mock(Request::class);
		$mockRequest->shouldReceive('get')->andReturn('Test Category controller');

		$mockDTOOutput = Mockery::mock(ListCategoriesOutputDto::class,[
			[],1,1,1,1,1,1,1
		]);
		$mockUseCase = Mockery::mock(ListCategoriesUseCase::class);
		$mockUseCase->shouldReceive('execute')->andReturn($mockDTOOutput);

		$controller = new CategoryController();
		$response = $controller->index($mockRequest, $mockUseCase);

		$this->assertIsObject($response->resource);
		$this->assertArrayHasKey('meta', $response->additional);

		/**
		 * Spies
		 */
		$mockUseCaseSpy = Mockery::spy(ListCategoriesUseCase::class);
		$mockUseCaseSpy->shouldReceive('execute')->andReturn($mockDTOOutput);
		$controller->index($mockRequest, $mockUseCaseSpy);
		$mockUseCaseSpy->shouldHaveReceived('execute');
    }
}
