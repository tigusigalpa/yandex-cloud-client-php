<?php

declare(strict_types=1);

namespace Tigusigalpa\YandexCloudClient\Resources;

use Tigusigalpa\YandexCloudClient\Exceptions\ApiException;
use Tigusigalpa\YandexCloudClient\Exceptions\AuthenticationException;
use Tigusigalpa\YandexCloudClient\Exceptions\ValidationException;

/**
 * Service Account Resource
 * 
 * Manages Yandex Cloud Service Accounts
 * @see https://yandex.cloud/ru/docs/iam/api-ref/ServiceAccount/
 */
class ServiceAccountResource extends AbstractResource
{
    private const BASE_URI = 'https://iam.api.cloud.yandex.net/iam/v1/serviceAccounts';

    /**
     * List service accounts in a folder
     *
     * @param string $folderId Folder ID
     * @param int|null $pageSize Maximum number of results per page (default: 100, max: 1000)
     * @param string|null $pageToken Page token for pagination
     * @param string|null $filter Filter expression
     * @return array
     * @throws ApiException
     * @throws AuthenticationException
     * @throws ValidationException
     */
    public function list(
        string $folderId,
        ?int $pageSize = null,
        ?string $pageToken = null,
        ?string $filter = null
    ): array {
        if (empty($folderId)) {
            throw new ValidationException('Folder ID is required');
        }

        $query = $this->buildQueryString([
            'folderId' => $folderId,
            'pageSize' => $pageSize,
            'pageToken' => $pageToken,
            'filter' => $filter,
        ]);

        return $this->makeRequest('GET', self::BASE_URI . $query);
    }

    /**
     * Get service account details
     *
     * @param string $serviceAccountId Service account ID
     * @return array
     * @throws ApiException
     * @throws AuthenticationException
     * @throws ValidationException
     */
    public function get(string $serviceAccountId): array
    {
        if (empty($serviceAccountId)) {
            throw new ValidationException('Service account ID is required');
        }

        return $this->makeRequest('GET', self::BASE_URI . '/' . $serviceAccountId);
    }

    /**
     * Create a new service account
     *
     * @param string $folderId Folder ID where service account will be created
     * @param string $name Service account name
     * @param string|null $description Service account description
     * @param array|null $labels Labels as key-value pairs
     * @return array
     * @throws ApiException
     * @throws AuthenticationException
     * @throws ValidationException
     */
    public function create(
        string $folderId,
        string $name,
        ?string $description = null,
        ?array $labels = null
    ): array {
        if (empty($folderId)) {
            throw new ValidationException('Folder ID is required');
        }

        if (empty($name)) {
            throw new ValidationException('Service account name is required');
        }

        $body = array_filter([
            'folderId' => $folderId,
            'name' => $name,
            'description' => $description,
            'labels' => $labels,
        ], fn($value) => $value !== null);

        return $this->makeRequest('POST', self::BASE_URI, [
            'json' => $body,
        ]);
    }

    /**
     * Update service account
     *
     * @param string $serviceAccountId Service account ID
     * @param array $updateData Update data (name, description, labels)
     * @return array
     * @throws ApiException
     * @throws AuthenticationException
     * @throws ValidationException
     */
    public function update(string $serviceAccountId, array $updateData): array
    {
        if (empty($serviceAccountId)) {
            throw new ValidationException('Service account ID is required');
        }

        if (empty($updateData)) {
            throw new ValidationException('Update data is required');
        }

        $updateMask = implode(',', array_keys($updateData));

        return $this->makeRequest('PATCH', self::BASE_URI . '/' . $serviceAccountId, [
            'json' => $updateData,
            'query' => ['updateMask' => $updateMask],
        ]);
    }

    /**
     * Delete service account
     *
     * @param string $serviceAccountId Service account ID
     * @return array
     * @throws ApiException
     * @throws AuthenticationException
     * @throws ValidationException
     */
    public function delete(string $serviceAccountId): array
    {
        if (empty($serviceAccountId)) {
            throw new ValidationException('Service account ID is required');
        }

        return $this->makeRequest('DELETE', self::BASE_URI . '/' . $serviceAccountId);
    }

    /**
     * List operations for service account
     *
     * @param string $serviceAccountId Service account ID
     * @param int|null $pageSize Maximum number of results per page
     * @param string|null $pageToken Page token for pagination
     * @return array
     * @throws ApiException
     * @throws AuthenticationException
     * @throws ValidationException
     */
    public function listOperations(
        string $serviceAccountId,
        ?int $pageSize = null,
        ?string $pageToken = null
    ): array {
        if (empty($serviceAccountId)) {
            throw new ValidationException('Service account ID is required');
        }

        $query = $this->buildQueryString([
            'pageSize' => $pageSize,
            'pageToken' => $pageToken,
        ]);

        return $this->makeRequest(
            'GET',
            self::BASE_URI . '/' . $serviceAccountId . '/operations' . $query
        );
    }

    /**
     * List access bindings for service account
     *
     * @param string $serviceAccountId Service account ID
     * @param int|null $pageSize Maximum number of results per page
     * @param string|null $pageToken Page token for pagination
     * @return array
     * @throws ApiException
     * @throws AuthenticationException
     * @throws ValidationException
     */
    public function listAccessBindings(
        string $serviceAccountId,
        ?int $pageSize = null,
        ?string $pageToken = null
    ): array {
        if (empty($serviceAccountId)) {
            throw new ValidationException('Service account ID is required');
        }

        $query = $this->buildQueryString([
            'pageSize' => $pageSize,
            'pageToken' => $pageToken,
        ]);

        return $this->makeRequest(
            'GET',
            self::BASE_URI . '/' . $serviceAccountId . ':listAccessBindings' . $query
        );
    }

    /**
     * Set access bindings for service account
     *
     * @param string $serviceAccountId Service account ID
     * @param array $accessBindings Array of access bindings
     * @return array
     * @throws ApiException
     * @throws AuthenticationException
     * @throws ValidationException
     */
    public function setAccessBindings(string $serviceAccountId, array $accessBindings): array
    {
        if (empty($serviceAccountId)) {
            throw new ValidationException('Service account ID is required');
        }

        return $this->makeRequest(
            'POST',
            self::BASE_URI . '/' . $serviceAccountId . ':setAccessBindings',
            ['json' => ['accessBindings' => $accessBindings]]
        );
    }

    /**
     * Update access bindings for service account
     *
     * @param string $serviceAccountId Service account ID
     * @param array $accessBindingDeltas Array of access binding deltas
     * @return array
     * @throws ApiException
     * @throws AuthenticationException
     * @throws ValidationException
     */
    public function updateAccessBindings(string $serviceAccountId, array $accessBindingDeltas): array
    {
        if (empty($serviceAccountId)) {
            throw new ValidationException('Service account ID is required');
        }

        return $this->makeRequest(
            'POST',
            self::BASE_URI . '/' . $serviceAccountId . ':updateAccessBindings',
            ['json' => ['accessBindingDeltas' => $accessBindingDeltas]]
        );
    }

    /**
     * Helper: Add role to service account
     *
     * @param string $serviceAccountId Service account ID
     * @param string $subjectId Subject ID (user or service account)
     * @param string $roleId Role ID
     * @param string $subjectType Subject type (userAccount, serviceAccount, etc.)
     * @return array
     * @throws ApiException
     * @throws AuthenticationException
     * @throws ValidationException
     */
    public function addRole(
        string $serviceAccountId,
        string $subjectId,
        string $roleId,
        string $subjectType = 'userAccount'
    ): array {
        return $this->updateAccessBindings($serviceAccountId, [
            [
                'action' => 'ADD',
                'accessBinding' => [
                    'roleId' => $roleId,
                    'subject' => [
                        'id' => $subjectId,
                        'type' => $subjectType,
                    ],
                ],
            ],
        ]);
    }

    /**
     * Helper: Remove role from service account
     *
     * @param string $serviceAccountId Service account ID
     * @param string $subjectId Subject ID
     * @param string $roleId Role ID
     * @return array
     * @throws ApiException
     * @throws AuthenticationException
     * @throws ValidationException
     */
    public function removeRole(string $serviceAccountId, string $subjectId, string $roleId): array
    {
        return $this->updateAccessBindings($serviceAccountId, [
            [
                'action' => 'REMOVE',
                'accessBinding' => [
                    'roleId' => $roleId,
                    'subject' => ['id' => $subjectId],
                ],
            ],
        ]);
    }
}
