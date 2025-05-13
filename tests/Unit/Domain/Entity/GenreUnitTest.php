<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Category;
use PHPUnit\Framework\TestCase;
use Core\Domain\Entity\Genre;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\ValueObject\Uuid;
use DateTime;
use Dom\Entity;
use Illuminate\Support\Facades\Date;
use Ramsey\Uuid\Nonstandard\Uuid as NonstandardUuid;
use Ramsey\Uuid\Uuid as RamseyUuid;

class GenreUnitTest extends TestCase
{
	private Genre $genre;
	private string $uuid;
	private DateTime $date;
	protected function setUp(): void
	{
		$this->uuid = RamseyUuid::uuid4()->toString();
		$this->date = new DateTime(date('Y-m-d H:i:s'));

		$this->genre = new Genre(
			name: 'New Genre',
			id: new Uuid($this->uuid),
			description: 'Description of the new genre',
			isActive: true,
			createdAt: $this->date,
			categoriesId: [],
		);

		parent::setUp();
	}
    public function test_attributes(): void
    {

		$this->assertEquals($this->uuid, $this->genre->id());
		$this->assertEquals('New Genre', $this->genre->name);
		$this->assertEquals('Description of the new genre', $this->genre->description);
		$this->assertEquals(true, $this->genre->isActive);
		$this->assertEquals(date('Y-m-d H:i:s'), $this->genre->createdAt('Y-m-d H:i:s'));
    }

	public function test_attributes_create(): void
	{

		$this->assertEquals('New Genre', $this->genre->name);
		$this->assertEquals('Description of the new genre', $this->genre->description);
		$this->assertEquals(true, $this->genre->isActive);
		$this->assertNotNull($this->genre->id());
		$this->assertNotNull($this->genre->createdAt());
	}

	public function test_deactivate(): void
	{

		$this->assertTrue($this->genre->isActive);
		$this->genre->deactivate();
		$this->assertFalse($this->genre->isActive);
	}
	public function test_activate(): void
	{
		$genre = new Genre(
			name: 'New Genre',
			description: 'Description of the new genre',
			isActive: false,
		);

		$this->assertFalse($genre->isActive);
		$genre->activate();
		$this->assertTrue($genre->isActive);
	}

	public function test_update(): void
	{

		$this->assertEquals('New Genre', $this->genre->name);
		$this->assertEquals('Description of the new genre', $this->genre->description);

		$this->genre->update('Updated Genre', 'Updated description');

		$this->assertEquals('Updated Genre', $this->genre->name);
		$this->assertEquals('Updated description', $this->genre->description);
	}

	public function test_entity_exception()
	{
		$this->expectException(EntityValidationException::class);
		
		new Genre(
			name: 'N'
		);
	}

	public function test_entity_update_exception()
	{
		$this->expectException(EntityValidationException::class);
		$this->genre->update(name: 'N');
	}

	public function test_add_category_to_genre()
	{
		$categoryId1 = RamseyUuid::uuid4()->toString();
		$categoryId2 = RamseyUuid::uuid4()->toString();

		$this->assertIsArray($this->genre->categoriesId());
		$this->assertCount(0, $this->genre->categoriesId());

		$this->genre->addCategory(categoryId: $categoryId1);
		$this->genre->addCategory(categoryId: $categoryId2);

		$this->assertCount(2, $this->genre->categoriesId());

		$this->genre->addCategory(categoryId: $categoryId1);
		$this->assertCount(2, $this->genre->categoriesId());
	}

	public function test_remove_category_to_genre()
	{
		$categoryId1 = RamseyUuid::uuid4()->toString();
		$categoryId2 = RamseyUuid::uuid4()->toString();

		$this->genre->addCategory(categoryId: $categoryId1);
		$this->genre->addCategory(categoryId: $categoryId2);

		$this->genre->removeCategory(categoryId: $categoryId1);
		$this->assertCount(1, $this->genre->categoriesId());

		$this->assertFalse(in_array($categoryId1, $this->genre->categoriesId()));		
	}
}
