<?php

declare(strict_types=1);

namespace Tigusigalpa\YandexCloudClient\Tests\Unit\Auth;

use PHPUnit\Framework\TestCase;
use Tigusigalpa\YandexCloudClient\Auth\IamTokenManager;
use Tigusigalpa\YandexCloudClient\Exceptions\AuthenticationException;

class IamTokenManagerTest extends TestCase
{
    public function testConstructorThrowsExceptionForEmptyToken(): void
    {
        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('OAuth token cannot be empty');

        new IamTokenManager('');
    }

    public function testConstructorAcceptsValidToken(): void
    {
        $manager = new IamTokenManager('test_token');

        $this->assertInstanceOf(IamTokenManager::class, $manager);
    }

    public function testGetOAuthTokenReturnsToken(): void
    {
        $token = 'test_oauth_token';
        $manager = new IamTokenManager($token);

        $this->assertEquals($token, $manager->getOAuthToken());
    }

    public function testHasValidCachedTokenReturnsFalseInitially(): void
    {
        $manager = new IamTokenManager('test_token');

        $this->assertFalse($manager->hasValidCachedToken());
    }

    public function testClearCacheResetsToken(): void
    {
        $manager = new IamTokenManager('test_token');
        $manager->clearCache();

        $this->assertFalse($manager->hasValidCachedToken());
    }
}
