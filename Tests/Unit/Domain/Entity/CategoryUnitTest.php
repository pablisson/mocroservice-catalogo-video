<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Category;
use Core\Domain\Exception\EntityValidationException;
use PHPUnit\Framework\TestCase;
use Throwable;

class CategoryUnitTest extends TestCase
{
	
	public function test_attributes(){
		$category = new Category(
			name: 'Category 1',
			description: 'Description 1',
			isActive: true
		);

		$this->assertEquals('Category 1', $category->name());
		$this->assertEquals('Description 1', $category->description());
		$this->assertTrue(true, $category->isActive());
	}

	public function test_activated(){
		$category = new Category(
			name: 'Category 1',
		);

		$this->assertTrue($category->isActive());
		$category->deactivate();

		$this->assertFalse($category->isActive());
		$category->activate();
		$this->assertTrue($category->isActive());
	}

	public function test_update(){
		$uuid = 'uuid.value';
		$category = new Category(
			name: 'Category 1',
			description: 'Description 1',
			isActive: true
		);

		$category->update(
			name: 'new name',
			description: 'new Description 1'
		);

		$this->assertEquals('new name', $category->name());
		$this->assertEquals('new Description 1', $category->description());
	}

	public function test_exception_name()
	{
		try{
			$nome = 'c5';
			new Category(
				name: $nome,
				description: 'Description 1'
			);
			$this->assertLessThan(3, strlen($nome));			
		}catch( Throwable $th){
			$this->assertLessThan(3, strlen($nome));
			$this->isInstanceOf(EntityValidationException::class, $th);
		}
	}


}