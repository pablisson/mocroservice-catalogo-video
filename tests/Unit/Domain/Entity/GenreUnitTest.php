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
        $genre = new Genre(
			id: new Uuid($uuid), 
			name: 'New Genre',
			description: 'Description of the new genre',
			isActive: true,
			createdAt: new DateTime(date('Y-m-d H:i:s')),
		);
    }
}
