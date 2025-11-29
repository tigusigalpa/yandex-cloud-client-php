<?php

declare(strict_types=1);

namespace Tigusigalpa\YandexCloudClient\Resources;

use Tigusigalpa\YandexCloudClient\Exceptions\ApiException;
use Tigusigalpa\YandexCloudClient\Exceptions\ValidationException;

/**
 * Cloud API resource
 * @see https://yandex.cloud/ru/docs/resource-manager/api-ref/Cloud/
 */
class CloudResource extends AbstractResource
{
    /**
     * Get list of clouds
     *
     * @param string|null $organizationId Organization ID to filter by
     * @param int|null $pageSize Maximum number of results per page
     * @param string|null $pageToken Page token for pagination
     * @return array
     * @throws ApiException
     * @see https://yandex.cloud/ru/docs/resource-manager/api-ref/Cloud/list
     */
    public function list(?string $organizationId = null, ?int $pageSize = null, ?string $pageToken = null): array
    {
        $query = $this->buildQueryString([
            'organizationId' => $organizationId,
            'pageSize' => $pageSize,
            'pageToken' => $pageToken,
        ]);

        return $this->makeRequest('GET', 'resource-manager/v1/clouds' . $query);
    }

    /**
     * Get cloud details
     *
     * @param string $cloudId Cloud ID
     * @return array
     * @throws ApiException
     * @throws ValidationException
     * @see https://yandex.cloud/ru/docs/resource-manager/api-ref/Cloud/get
     */
    public function get(string $cloudId): array
    {
        if (empty($cloudId)) {
            throw new ValidationException('Cloud ID cannot be empty');
        }

        return $this->makeRequest('GET', "resource-manager/v1/clouds/{$cloudId}");
    }

    /**
     * Create cloud
     *
     * @param string $organizationId Organization ID
     * @param string $name Cloud name
     * @param string|null $description Cloud description
     * @param array|null $labels Cloud labels
     * @return array
     * @throws ApiException
     * @throws ValidationException
     * @see https://yandex.cloud/ru/docs/resource-manager/api-ref/Cloud/create
     */
    public function create(string $organizationId, string $name, ?string $description = null, ?array $labels = null): array
    {
        if (empty($organizationId)) {
            throw new ValidationException('Organization ID cannot be empty');
        }

        if (empty($name)) {
            throw new ValidationException('Cloud name cannot be empty');
        }

        $data = [
            'organizationId' => $organizationId,
            'name' => $name,
        ];

        if ($description !== null) {
            $data['description'] = $description;
        }

        if ($labels !== null) {
            $data['labels'] = $labels;
        }

        return $this->makeRequest('POST', 'resource-manager/v1/clouds', [
            'json' => $data,
        ]);
    }

    /**
     * Update cloud
     *
     * @param string $cloudId Cloud ID
     * @param array $data Update data (name, description, labels)
     * @return array
     * @throws ApiException
     * @throws ValidationException
     * @see https://yandex.cloud/ru/docs/resource-manager/api-ref/Cloud/update
     */
    public function update(string $cloudId, array $data): array
    {
        if (empty($cloudId)) {
            throw new ValidationException('Cloud ID cannot be empty');
        }

        if (empty($data)) {
            throw new ValidationException('Update data cannot be empty');
        }

        return $this->makeRequest('PATCH', "resource-manager/v1/clouds/{$cloudId}", [
            'json' => $data,
        ]);
    }

    /**
     * Delete cloud
     *
     * @param string $cloudId Cloud ID
     * @return array
     * @throws ApiException
     * @throws ValidationException
     * @see https://yandex.cloud/ru/docs/resource-manager/api-ref/Cloud/delete
     */
    public function delete(string $cloudId): array
    {
        if (empty($cloudId)) {
            throw new ValidationException('Cloud ID cannot be empty');
        }

        return $this->makeRequest('DELETE', "resource-manager/v1/clouds/{$cloudId}");
    }

    /**
     * Set access bindings for cloud
     *
     * @param string $cloudId Cloud ID
     * @param array $accessBindings Array of access bindings
     * @return array
     * @throws ApiException
     * @throws ValidationException
     * @see https://yandex.cloud/ru/docs/resource-manager/api-ref/Cloud/setAccessBindings
     */
    public function setAccessBindings(string $cloudId, array $accessBindings): array
    {
        if (empty($cloudId)) {
            throw new ValidationException('Cloud ID cannot be empty');
        }

        if (empty($accessBindings)) {
            throw new ValidationException('Access bindings cannot be empty');
        }

        return $this->makeRequest('POST', "resource-manager/v1/clouds/{$cloudId}:setAccessBindings", [
            'json' => [
                'accessBindings' => $accessBindings,
            ],
        ]);
    }

    /**
     * List access bindings for cloud
     *
     * @param string $cloudId Cloud ID
     * @param int|null $pageSize Maximum number of results per page
     * @param string|null $pageToken Page token for pagination
     * @return array
     * @throws ApiException
     * @throws ValidationException
     * @see https://yandex.cloud/ru/docs/resource-manager/api-ref/Cloud/listAccessBindings
     */
    public function listAccessBindings(string $cloudId, ?int $pageSize = null, ?string $pageToken = null): array
    {
        if (empty($cloudId)) {
            throw new ValidationException('Cloud ID cannot be empty');
        }

        $query = $this->buildQueryString([
            'pageSize' => $pageSize,
            'pageToken' => $pageToken,
        ]);

        return $this->makeRequest('GET', "resource-manager/v1/clouds/{$cloudId}:listAccessBindings" . $query);
    }

    /**
     * Update access bindings for cloud
     *
     * @param string $cloudId Cloud ID
     * @param array $accessBindingDeltas Array of access binding deltas
     * @return array
     * @throws ApiException
     * @throws ValidationException
     * @see https://yandex.cloud/ru/docs/resource-manager/api-ref/Cloud/updateAccessBindings
     */
    public function updateAccessBindings(string $cloudId, array $accessBindingDeltas): array
    {
        if (empty($cloudId)) {
            throw new ValidationException('Cloud ID cannot be empty');
        }

        if (empty($accessBindingDeltas)) {
            throw new ValidationException('Access binding deltas cannot be empty');
        }

        return $this->makeRequest('POST', "resource-manager/v1/clouds/{$cloudId}:updateAccessBindings", [
            'json' => [
                'accessBindingDeltas' => $accessBindingDeltas,
            ],
        ]);
    }

    /**
     * Add role to cloud (helper method)
     *
     * @param string $cloudId Cloud ID
     * @param string $subjectId Subject ID (user or service account)
     * @param string $roleId Role ID
     * @param string $subjectType Subject type: 'userAccount' or 'serviceAccount'
     * @return array
     * @throws ApiException
     * @throws ValidationException
     */
    public function addRole(string $cloudId, string $subjectId, string $roleId, string $subjectType = 'userAccount'): array
    {
        return $this->updateAccessBindings($cloudId, [
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
     * Remove role from cloud (helper method)
     *
     * @param string $cloudId Cloud ID
     * @param string $subjectId Subject ID (user or service account)
     * @param string $roleId Role ID
     * @param string $subjectType Subject type: 'userAccount' or 'serviceAccount'
     * @return array
     * @throws ApiException
     * @throws ValidationException
     */
    public function removeRole(string $cloudId, string $subjectId, string $roleId, string $subjectType = 'userAccount'): array
    {
        return $this->updateAccessBindings($cloudId, [
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
