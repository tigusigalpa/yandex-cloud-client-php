<?php

declare(strict_types=1);

namespace Tigusigalpa\YandexCloudClient\Resources;

use Tigusigalpa\YandexCloudClient\Exceptions\ApiException;
use Tigusigalpa\YandexCloudClient\Exceptions\ValidationException;

/**
 * Folder API resource
 * @see https://yandex.cloud/ru/docs/resource-manager/api-ref/Folder/
 */
class FolderResource extends AbstractResource
{
    /**
     * Get list of folders
     *
     * @param string $cloudId Cloud ID to filter by
     * @param int|null $pageSize Maximum number of results per page
     * @param string|null $pageToken Page token for pagination
     * @return array
     * @throws ApiException
     * @throws ValidationException
     * @see https://yandex.cloud/ru/docs/resource-manager/api-ref/Folder/list
     */
    public function list(string $cloudId, ?int $pageSize = null, ?string $pageToken = null): array
    {
        if (empty($cloudId)) {
            throw new ValidationException('Cloud ID cannot be empty');
        }

        $query = $this->buildQueryString([
            'cloudId' => $cloudId,
            'pageSize' => $pageSize,
            'pageToken' => $pageToken,
        ]);

        return $this->makeRequest('GET', 'resource-manager/v1/folders' . $query);
    }

    /**
     * Get folder details
     *
     * @param string $folderId Folder ID
     * @return array
     * @throws ApiException
     * @throws ValidationException
     * @see https://yandex.cloud/ru/docs/resource-manager/api-ref/Folder/get
     */
    public function get(string $folderId): array
    {
        if (empty($folderId)) {
            throw new ValidationException('Folder ID cannot be empty');
        }

        return $this->makeRequest('GET', "resource-manager/v1/folders/{$folderId}");
    }

    /**
     * Create folder
     *
     * @param string $cloudId Cloud ID
     * @param string $name Folder name
     * @param string|null $description Folder description
     * @param array|null $labels Folder labels
     * @return array
     * @throws ApiException
     * @throws ValidationException
     * @see https://yandex.cloud/ru/docs/resource-manager/api-ref/Folder/create
     */
    public function create(string $cloudId, string $name, ?string $description = null, ?array $labels = null): array
    {
        if (empty($cloudId)) {
            throw new ValidationException('Cloud ID cannot be empty');
        }

        if (empty($name)) {
            throw new ValidationException('Folder name cannot be empty');
        }

        $data = [
            'cloudId' => $cloudId,
            'name' => $name,
        ];

        if ($description !== null) {
            $data['description'] = $description;
        }

        if ($labels !== null) {
            $data['labels'] = $labels;
        }

        return $this->makeRequest('POST', 'resource-manager/v1/folders', [
            'json' => $data,
        ]);
    }

    /**
     * Update folder
     *
     * @param string $folderId Folder ID
     * @param array $data Update data (name, description, labels)
     * @return array
     * @throws ApiException
     * @throws ValidationException
     * @see https://yandex.cloud/ru/docs/resource-manager/api-ref/Folder/update
     */
    public function update(string $folderId, array $data): array
    {
        if (empty($folderId)) {
            throw new ValidationException('Folder ID cannot be empty');
        }

        if (empty($data)) {
            throw new ValidationException('Update data cannot be empty');
        }

        return $this->makeRequest('PATCH', "resource-manager/v1/folders/{$folderId}", [
            'json' => $data,
        ]);
    }

    /**
     * Delete folder
     *
     * @param string $folderId Folder ID
     * @return array
     * @throws ApiException
     * @throws ValidationException
     * @see https://yandex.cloud/ru/docs/resource-manager/api-ref/Folder/delete
     */
    public function delete(string $folderId): array
    {
        if (empty($folderId)) {
            throw new ValidationException('Folder ID cannot be empty');
        }

        return $this->makeRequest('DELETE', "resource-manager/v1/folders/{$folderId}");
    }

    /**
     * List operations for folder
     *
     * @param string $folderId Folder ID
     * @param int|null $pageSize Maximum number of results per page
     * @param string|null $pageToken Page token for pagination
     * @return array
     * @throws ApiException
     * @throws ValidationException
     * @see https://yandex.cloud/ru/docs/resource-manager/api-ref/Folder/listOperations
     */
    public function listOperations(string $folderId, ?int $pageSize = null, ?string $pageToken = null): array
    {
        if (empty($folderId)) {
            throw new ValidationException('Folder ID cannot be empty');
        }

        $query = $this->buildQueryString([
            'pageSize' => $pageSize,
            'pageToken' => $pageToken,
        ]);

        return $this->makeRequest('GET', "resource-manager/v1/folders/{$folderId}/operations" . $query);
    }

    /**
     * Set access bindings for folder
     *
     * @param string $folderId Folder ID
     * @param array $accessBindings Array of access bindings
     * @return array
     * @throws ApiException
     * @throws ValidationException
     * @see https://yandex.cloud/ru/docs/resource-manager/api-ref/Folder/setAccessBindings
     */
    public function setAccessBindings(string $folderId, array $accessBindings): array
    {
        if (empty($folderId)) {
            throw new ValidationException('Folder ID cannot be empty');
        }

        if (empty($accessBindings)) {
            throw new ValidationException('Access bindings cannot be empty');
        }

        return $this->makeRequest('POST', "resource-manager/v1/folders/{$folderId}:setAccessBindings", [
            'json' => [
                'accessBindings' => $accessBindings,
            ],
        ]);
    }

    /**
     * List access bindings for folder
     *
     * @param string $folderId Folder ID
     * @param int|null $pageSize Maximum number of results per page
     * @param string|null $pageToken Page token for pagination
     * @return array
     * @throws ApiException
     * @throws ValidationException
     * @see https://yandex.cloud/ru/docs/resource-manager/api-ref/Folder/listAccessBindings
     */
    public function listAccessBindings(string $folderId, ?int $pageSize = null, ?string $pageToken = null): array
    {
        if (empty($folderId)) {
            throw new ValidationException('Folder ID cannot be empty');
        }

        $query = $this->buildQueryString([
            'pageSize' => $pageSize,
            'pageToken' => $pageToken,
        ]);

        return $this->makeRequest('GET', "resource-manager/v1/folders/{$folderId}:listAccessBindings" . $query);
    }

    /**
     * Update access bindings for folder
     *
     * @param string $folderId Folder ID
     * @param array $accessBindingDeltas Array of access binding deltas
     * @return array
     * @throws ApiException
     * @throws ValidationException
     * @see https://yandex.cloud/ru/docs/resource-manager/api-ref/Folder/updateAccessBindings
     */
    public function updateAccessBindings(string $folderId, array $accessBindingDeltas): array
    {
        if (empty($folderId)) {
            throw new ValidationException('Folder ID cannot be empty');
        }

        if (empty($accessBindingDeltas)) {
            throw new ValidationException('Access binding deltas cannot be empty');
        }

        return $this->makeRequest('POST', "resource-manager/v1/folders/{$folderId}:updateAccessBindings", [
            'json' => [
                'accessBindingDeltas' => $accessBindingDeltas,
            ],
        ]);
    }

    /**
     * Add role to folder (helper method)
     *
     * @param string $folderId Folder ID
     * @param string $subjectId Subject ID (user or service account)
     * @param string $roleId Role ID
     * @param string $subjectType Subject type: 'userAccount' or 'serviceAccount'
     * @return array
     * @throws ApiException
     * @throws ValidationException
     */
    public function addRole(string $folderId, string $subjectId, string $roleId, string $subjectType = 'userAccount'): array
    {
        return $this->updateAccessBindings($folderId, [
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
     * Remove role from folder (helper method)
     *
     * @param string $folderId Folder ID
     * @param string $subjectId Subject ID (user or service account)
     * @param string $roleId Role ID
     * @param string $subjectType Subject type: 'userAccount' or 'serviceAccount'
     * @return array
     * @throws ApiException
     * @throws ValidationException
     */
    public function removeRole(string $folderId, string $subjectId, string $roleId, string $subjectType = 'userAccount'): array
    {
        return $this->updateAccessBindings($folderId, [
            [
                'action' => 'REMOVE',
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
}
