<?php

declare(strict_types=1);

namespace Tigusigalpa\YandexCloudClient\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tigusigalpa\YandexCloudClient\YandexCloudClient;
use Tigusigalpa\YandexCloudClient\Exceptions\AuthenticationException;
use Tigusigalpa\YandexCloudClient\Resources\OrganizationResource;
use Tigusigalpa\YandexCloudClient\Resources\CloudResource;
use Tigusigalpa\YandexCloudClient\Resources\FolderResource;
use Tigusigalpa\YandexCloudClient\Resources\RefreshTokenResource;

class YandexCloudClientTest extends TestCase
{
    public function testConstructorThrowsExceptionForEmptyToken(): void
    {
        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('OAuth token cannot be empty');

        new YandexCloudClient('');
    }

    public function testConstructorAcceptsValidToken(): void
    {
        $client = new YandexCloudClient('test_token');

        $this->assertInstanceOf(YandexCloudClient::class, $client);
    }

    public function testOrganizationsReturnsOrganizationResource(): void
    {
        $client = new YandexCloudClient('test_token');

        $this->assertInstanceOf(OrganizationResource::class, $client->organizations());
    }

    public function testCloudsReturnsCloudResource(): void
    {
        $client = new YandexCloudClient('test_token');

        $this->assertInstanceOf(CloudResource::class, $client->clouds());
    }

    public function testFoldersReturnsFolderResource(): void
    {
        $client = new YandexCloudClient('test_token');

        $this->assertInstanceOf(FolderResource::class, $client->folders());
    }

    public function testRefreshTokensReturnsRefreshTokenResource(): void
    {
        $client = new YandexCloudClient('test_token');

        $this->assertInstanceOf(RefreshTokenResource::class, $client->refreshTokens());
    }

    public function testGetOauthTokenReturnsToken(): void
    {
        $token = 'test_oauth_token';
        $client = new YandexCloudClient($token);

        $this->assertEquals($token, $client->getOauthToken());
    }
}
