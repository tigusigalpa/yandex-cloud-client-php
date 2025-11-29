<?php

declare(strict_types=1);

namespace Tigusigalpa\YandexCloudClient\Tests\Unit\Resources;

use PHPUnit\Framework\TestCase;
use Tigusigalpa\YandexCloudClient\Exceptions\ValidationException;

class OrganizationResourceTest extends TestCase
{
    public function testGetThrowsExceptionForEmptyId(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Organization ID cannot be empty');

        // This test would require mocking the resource
        // For now, it's a placeholder for the test structure
        $this->assertTrue(true);
    }

    public function testUpdateThrowsExceptionForEmptyId(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Organization ID cannot be empty');

        // Placeholder test
        $this->assertTrue(true);
    }

    public function testUpdateThrowsExceptionForEmptyData(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Update data cannot be empty');

        // Placeholder test
        $this->assertTrue(true);
    }
}
