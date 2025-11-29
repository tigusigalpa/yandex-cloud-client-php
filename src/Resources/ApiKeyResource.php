<?php

declare(strict_types=1);

namespace Tigusigalpa\YandexCloudClient\Resources;

use Tigusigalpa\YandexCloudClient\Exceptions\ApiException;
use Tigusigalpa\YandexCloudClient\Exceptions\AuthenticationException;
use Tigusigalpa\YandexCloudClient\Exceptions\ValidationException;

/**
 * API Key Resource
 * 
 * Manages API keys for service accounts
 * @see https://yandex.cloud/ru/docs/iam/api-ref/ApiKey/
 */
class ApiKeyResource extends AbstractResource
{
    private const BASE_URI = 'https://iam.api.cloud.yandex.net/iam/v1/apiKeys';

    /**
     * List API keys for a service account
     *
     * @param string $serviceAccountId Service account ID
     * @param int|null $pageSize Maximum number of results per page (default: 100, max: 1000)
     * @param string|null $pageToken Page token for pagination
     * @return array
     * @throws ApiException
     * @throws AuthenticationException
     * @throws ValidationException
     */
    public function list(
        string $serviceAccountId,
        ?int $pageSize = null,
        ?string $pageToken = null
    ): array {
        if (empty($serviceAccountId)) {
            throw new ValidationException('Service account ID is required');
        }

        $query = $this->buildQueryString([
            'serviceAccountId' => $serviceAccountId,
            'pageSize' => $pageSize,
            'pageToken' => $pageToken,
        ]);

        return $this->makeRequest('GET', self::BASE_URI . $query);
    }

    /**
     * Get API key details
     *
     * @param string $apiKeyId API key ID
     * @return array
     * @throws ApiException
     * @throws AuthenticationException
     * @throws ValidationException
     */
    public function get(string $apiKeyId): array
    {
        if (empty($apiKeyId)) {
            throw new ValidationException('API key ID is required');
        }

        return $this->makeRequest('GET', self::BASE_URI . '/' . $apiKeyId);
    }

    /**
     * Create a new API key
     *
     * @param string $serviceAccountId Service account ID
     * @param string|null $description API key description
     * @param string|null $scope Scope of the API key
     * @param string|null $expiresAt Expiration timestamp (RFC3339 format)
     * @return array Response contains 'secret' field with the API key value (shown only once!)
     * @throws ApiException
     * @throws AuthenticationException
     * @throws ValidationException
     */
    public function create(
        string $serviceAccountId,
        ?string $description = null,
        ?string $scope = null,
        ?string $expiresAt = null
    ): array {
        if (empty($serviceAccountId)) {
            throw new ValidationException('Service account ID is required');
        }

        $body = array_filter([
            'serviceAccountId' => $serviceAccountId,
            'description' => $description,
            'scope' => $scope,
            'expiresAt' => $expiresAt,
        ], fn($value) => $value !== null);

        return $this->makeRequest('POST', self::BASE_URI, [
            'json' => $body,
        ]);
    }

    /**
     * Update API key
     *
     * @param string $apiKeyId API key ID
     * @param array $updateData Update data (description)
     * @return array
     * @throws ApiException
     * @throws AuthenticationException
     * @throws ValidationException
     */
    public function update(string $apiKeyId, array $updateData): array
    {
        if (empty($apiKeyId)) {
            throw new ValidationException('API key ID is required');
        }

        if (empty($updateData)) {
            throw new ValidationException('Update data is required');
        }

        $updateMask = implode(',', array_keys($updateData));

        return $this->makeRequest('PATCH', self::BASE_URI . '/' . $apiKeyId, [
            'json' => $updateData,
            'query' => ['updateMask' => $updateMask],
        ]);
    }

    /**
     * Delete API key
     *
     * @param string $apiKeyId API key ID
     * @return array
     * @throws ApiException
     * @throws AuthenticationException
     * @throws ValidationException
     */
    public function delete(string $apiKeyId): array
    {
        if (empty($apiKeyId)) {
            throw new ValidationException('API key ID is required');
        }

        return $this->makeRequest('DELETE', self::BASE_URI . '/' . $apiKeyId);
    }

    /**
     * List operations for API key
     *
     * @param string $apiKeyId API key ID
     * @param int|null $pageSize Maximum number of results per page
     * @param string|null $pageToken Page token for pagination
     * @return array
     * @throws ApiException
     * @throws AuthenticationException
     * @throws ValidationException
     */
    public function listOperations(
        string $apiKeyId,
        ?int $pageSize = null,
        ?string $pageToken = null
    ): array {
        if (empty($apiKeyId)) {
            throw new ValidationException('API key ID is required');
        }

        $query = $this->buildQueryString([
            'pageSize' => $pageSize,
            'pageToken' => $pageToken,
        ]);

        return $this->makeRequest(
            'GET',
            self::BASE_URI . '/' . $apiKeyId . '/operations' . $query
        );
    }
}
