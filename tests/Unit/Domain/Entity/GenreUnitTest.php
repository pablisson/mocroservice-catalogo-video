<?php

namespace Tests\Unit\Domain\Entity;

use PHPUnit\Framework\TestCase;
use Core\Domain\Entity\Genre;
use Core\Domain\ValueObject\Uuid;
use DateTime;
use Ramsey\Uuid\Uuid as RamseyUuid;

class GenreUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_attributes(): void
    {
		$uuid = (string)RamseyUuid::uuid4();
		$date = new DateTime(date('Y-m-d H:i:s'));
        $genre = new Genre(
			id: new Uuid($uuid), 
			name: 'New Genre',
			description: 'Description of the new genre',
			isActive: true,
			createdAt: $date,
		);

		$this->assertEquals($uuid, $genre->id());
		$this->assertEquals('New Genre', $genre->name);
		$this->assertEquals('Description of the new genre', $genre->description);
		$this->assertEquals(true, $genre->isActive);
		$this->assertEquals(date('Y-m-d H:i:s'), $genre->createdAt('Y-m-d H:i:s'));
    }

	public function test_attributes_create(): void
	{
		$genre = new Genre(
			name: 'New Genre',
			description: 'Description of the new genre',
			isActive: true,
		);

		$this->assertEquals('New Genre', $genre->name);
		$this->assertEquals('Description of the new genre', $genre->description);
		$this->assertEquals(true, $genre->isActive);
		$this->assertNotNull($genre->id());
		$this->assertNotNull($genre->createdAt());
	}
}
