<?php

declare(strict_types=1);

namespace Tigusigalpa\YandexCloudClient;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Tigusigalpa\YandexCloudClient\Auth\IamTokenManager;
use Tigusigalpa\YandexCloudClient\Exceptions\AuthenticationException;
use Tigusigalpa\YandexCloudClient\Resources\ApiKeyResource;
use Tigusigalpa\YandexCloudClient\Resources\CloudResource;
use Tigusigalpa\YandexCloudClient\Resources\FolderResource;
use Tigusigalpa\YandexCloudClient\Resources\OrganizationResource;
use Tigusigalpa\YandexCloudClient\Resources\RefreshTokenResource;
use Tigusigalpa\YandexCloudClient\Resources\ServiceAccountResource;
use Tigusigalpa\YandexCloudClient\Resources\UserAccountResource;
use Tigusigalpa\YandexCloudClient\Resources\YandexPassportUserAccountResource;

/**
 * Main client for Yandex Cloud API
 */
class YandexCloudClient
{
    private const IAM_BASE_URI = 'https://iam.api.cloud.yandex.net/';
    private const ORGANIZATION_BASE_URI = 'https://organization-manager.api.cloud.yandex.net/';
    private const RESOURCE_MANAGER_BASE_URI = 'https://resource-manager.api.cloud.yandex.net/';

    private ClientInterface $httpClient;
    private IamTokenManager $authManager;

    public function __construct(string $oauthToken, ?ClientInterface $httpClient = null)
    {
        if (empty($oauthToken)) {
            throw new AuthenticationException('OAuth token cannot be empty');
        }

        $this->authManager = new IamTokenManager($oauthToken);

        $this->httpClient = $httpClient ?? new Client([
            'timeout' => 30,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * Get Organization resource
     *
     * @return OrganizationResource
     */
    public function organizations(): OrganizationResource
    {
        return new OrganizationResource(
            $this->createClientWithBaseUri(self::ORGANIZATION_BASE_URI),
            $this->authManager
        );
    }

    /**
     * Get Cloud resource
     *
     * @return CloudResource
     */
    public function clouds(): CloudResource
    {
        return new CloudResource(
            $this->createClientWithBaseUri(self::RESOURCE_MANAGER_BASE_URI),
            $this->authManager
        );
    }

    /**
     * Get Folder resource
     *
     * @return FolderResource
     */
    public function folders(): FolderResource
    {
        return new FolderResource(
            $this->createClientWithBaseUri(self::RESOURCE_MANAGER_BASE_URI),
            $this->authManager
        );
    }

    /**
     * Get RefreshToken resource
     *
     * @return RefreshTokenResource
     */
    public function refreshTokens(): RefreshTokenResource
    {
        return new RefreshTokenResource(
            $this->createClientWithBaseUri(self::IAM_BASE_URI),
            $this->authManager
        );
    }

    /**
     * Get ServiceAccount resource
     *
     * @return ServiceAccountResource
     */
    public function serviceAccounts(): ServiceAccountResource
    {
        return new ServiceAccountResource(
            $this->createClientWithBaseUri(self::IAM_BASE_URI),
            $this->authManager
        );
    }

    /**
     * Get UserAccount resource
     *
     * @return UserAccountResource
     */
    public function userAccounts(): UserAccountResource
    {
        return new UserAccountResource(
            $this->createClientWithBaseUri(self::IAM_BASE_URI),
            $this->authManager
        );
    }

    /**
     * Get YandexPassportUserAccount resource
     *
     * @return YandexPassportUserAccountResource
     */
    public function yandexPassportUserAccounts(): YandexPassportUserAccountResource
    {
        return new YandexPassportUserAccountResource(
            $this->createClientWithBaseUri(self::IAM_BASE_URI),
            $this->authManager
        );
    }

    /**
     * Get ApiKey resource
     *
     * @return ApiKeyResource
     */
    public function apiKeys(): ApiKeyResource
    {
        return new ApiKeyResource(
            $this->createClientWithBaseUri(self::IAM_BASE_URI),
            $this->authManager
        );
    }

    /**
     * Get HTTP client
     *
     * @return ClientInterface
     */
    public function getHttpClient(): ClientInterface
    {
        return $this->httpClient;
    }

    /**
     * Get authentication manager
     *
     * @return IamTokenManager
     */
    public function getAuthManager(): IamTokenManager
    {
        return $this->authManager;
    }

    /**
     * Get OAuth token
     *
     * @return string
     */
    public function getOauthToken(): string
    {
        return $this->authManager->getOAuthToken();
    }

    /**
     * Create HTTP client with specific base URI
     *
     * @param string $baseUri
     * @return ClientInterface
     */
    private function createClientWithBaseUri(string $baseUri): ClientInterface
    {
        return new Client([
            'base_uri' => $baseUri,
            'timeout' => 30,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }
}
