<?php

namespace Core\UseCase\Genre;

use Core\Domain\Repository\GenreRepositoryInterface;
use Core\DTO\Genre\ListGenres\ListGenresInputDto;
use Core\DTO\Genre\ListGenres\ListGenresOutputDto;

class ListGenresUseCase
{
	public function __construct(
		protected GenreRepositoryInterface $repository
		)
	{
		
	}

	public function execute(ListGenresInputDto $inputDto): ListGenresOutputDto
	{
		$response = $this->repository->paginate(
			filter: $inputDto->filter,
			order: $inputDto->order,
			page: $inputDto->page,
			totalPage: $inputDto->totalPage

		);
		return new ListGenresOutputDto(
			items: (array) $response->items(),
			total: $response->total(),
			current_page: $response->currentPage(),
			last_page: $response->lastPage(),
			first_page: $response->firstPage(),
			per_page: $response->perPage(),
			to: $response->to(),
			from: $response->from(),
		);
	}

}
