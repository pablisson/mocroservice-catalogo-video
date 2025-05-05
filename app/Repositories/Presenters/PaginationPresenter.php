<?php

namespace App\Repositories\Presenters;
use Core\Domain\Repository\PaginationInterface;

class PaginationPresenter implements PaginationInterface
{
	public function __construct(
		protected array $items,
		protected int $total,
		protected int $lastPage,
		protected int $firstPage,
		protected int $currentPage,
		protected int $perPage,
		protected int $to,
		protected int $from
	) {
	}

	public function items(): array
	{
		return $this->items;
	}

	public function total(): int
	{
		return $this->total;
	}

	public function lastPage(): int
	{
		return $this->lastPage;
	}

	public function firstPage(): int
	{
		return $this->firstPage;
	}

	public function currentPage(): int
	{
		return $this->currentPage;
	}
	
	public function perPage(): int
	{
		return $this->perPage;
	}

	public function to(): int
	{
		return $this->to;
	}
	
	public function from(): int
	{
		return $this->from;
	}
}