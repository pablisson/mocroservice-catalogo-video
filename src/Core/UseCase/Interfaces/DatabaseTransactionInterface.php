<?php

namespace Core\UseCase\Interfaces;

interface DatabaseTransactionInterface
{	
	public function commit();
	public function rollback();

}