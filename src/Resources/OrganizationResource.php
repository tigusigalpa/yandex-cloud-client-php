<?php

declare(strict_types=1);

namespace Tigusigalpa\YandexCloudClient\Resources;

use Tigusigalpa\YandexCloudClient\Exceptions\ApiException;
use Tigusigalpa\YandexCloudClient\Exceptions\ValidationException;

/**
 * Organization API resource
 * @see https://yandex.cloud/ru/docs/organization/api-ref/Organization/
 */
class OrganizationResource extends AbstractResource
{
    /**
     * Get list of organizations
     *
     * @param int|null $pageSize Maximum number of results per page
     * @param string|null $pageToken Page token for pagination
     * @return array
     * @throws ApiException
     * @see https://yandex.cloud/ru/docs/organization/api-ref/Organization/list
     */
    public function list(?int $pageSize = null, ?string $pageToken = null): array
    {
        $query = $this->buildQueryString([
            'pageSize' => $pageSize,
            'pageToken' => $pageToken,
        ]);

        return $this->makeRequest('GET', 'organization-manager/v1/organizations' . $query);
    }

    /**
     * Get organization details
     *
     * @param string $organizationId Organization ID
     * @return array
     * @throws ApiException
     * @throws ValidationException
     * @see https://yandex.cloud/ru/docs/organization/api-ref/Organization/get
     */
    public function get(string $organizationId): array
    {
        if (empty($organizationId)) {
            throw new ValidationException('Organization ID cannot be empty');
        }

        return $this->makeRequest('GET', "organization-manager/v1/organizations/{$organizationId}");
    }

    /**
     * Update organization
     *
     * @param string $organizationId Organization ID
     * @param array $data Update data (name, description, title, labels)
     * @return array
     * @throws ApiException
     * @throws ValidationException
     * @see https://yandex.cloud/ru/docs/organization/api-ref/Organization/update
     */
    public function update(string $organizationId, array $data): array
    {
        if (empty($organizationId)) {
            throw new ValidationException('Organization ID cannot be empty');
        }

        if (empty($data)) {
            throw new ValidationException('Update data cannot be empty');
        }

        return $this->makeRequest('PATCH', "organization-manager/v1/organizations/{$organizationId}", [
            'json' => $data,
        ]);
    }

    /**
     * Set access bindings for organization
     *
     * @param string $organizationId Organization ID
     * @param array $accessBindings Array of access bindings
     * @return array
     * @throws ApiException
     * @throws ValidationException
     * @see https://yandex.cloud/ru/docs/organization/api-ref/Organization/setAccessBindings
     */
    public function setAccessBindings(string $organizationId, array $accessBindings): array
    {
        if (empty($organizationId)) {
            throw new ValidationException('Organization ID cannot be empty');
        }

        if (empty($accessBindings)) {
            throw new ValidationException('Access bindings cannot be empty');
        }

        return $this->makeRequest('POST', "organization-manager/v1/organizations/{$organizationId}:setAccessBindings", [
            'json' => [
                'accessBindings' => $accessBindings,
            ],
        ]);
    }

    /**
     * Update access bindings for organization
     *
     * @param string $organizationId Organization ID
     * @param array $accessBindingDeltas Array of access binding deltas
     * @return array
     * @throws ApiException
     * @throws ValidationException
     * @see https://yandex.cloud/ru/docs/organization/api-ref/Organization/updateAccessBindings
     */
    public function updateAccessBindings(string $organizationId, array $accessBindingDeltas): array
    {
        if (empty($organizationId)) {
            throw new ValidationException('Organization ID cannot be empty');
        }

        if (empty($accessBindingDeltas)) {
            throw new ValidationException('Access binding deltas cannot be empty');
        }

        return $this->makeRequest('POST', "organization-manager/v1/organizations/{$organizationId}:updateAccessBindings", [
            'json' => [
                'accessBindingDeltas' => $accessBindingDeltas,
            ],
        ]);
    }

    /**
     * List access bindings for organization
     *
     * @param string $organizationId Organization ID
     * @param int|null $pageSize Maximum number of results per page
     * @param string|null $pageToken Page token for pagination
     * @return array
     * @throws ApiException
     * @throws ValidationException
     * @see https://yandex.cloud/ru/docs/organization/api-ref/Organization/listAccessBindings
     */
    public function listAccessBindings(string $organizationId, ?int $pageSize = null, ?string $pageToken = null): array
    {
        if (empty($organizationId)) {
            throw new ValidationException('Organization ID cannot be empty');
        }

        $query = $this->buildQueryString([
            'pageSize' => $pageSize,
            'pageToken' => $pageToken,
        ]);

        return $this->makeRequest('GET', "organization-manager/v1/organizations/{$organizationId}:listAccessBindings" . $query);
    }

    /**
     * Add role to organization (helper method)
     *
     * @param string $organizationId Organization ID
     * @param string $subjectId Subject ID (user or service account)
     * @param string $roleId Role ID
     * @param string $subjectType Subject type: 'userAccount' or 'serviceAccount'
     * @return array
     * @throws ApiException
     * @throws ValidationException
     */
    public function addRole(string $organizationId, string $subjectId, string $roleId, string $subjectType = 'userAccount'): array
    {
        return $this->updateAccessBindings($organizationId, [
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
     * Remove role from organization (helper method)
     *
     * @param string $organizationId Organization ID
     * @param string $subjectId Subject ID (user or service account)
     * @param string $roleId Role ID
     * @param string $subjectType Subject type: 'userAccount' or 'serviceAccount'
     * @return array
     * @throws ApiException
     * @throws ValidationException
     */
    public function removeRole(string $organizationId, string $subjectId, string $roleId, string $subjectType = 'userAccount'): array
    {
        return $this->updateAccessBindings($organizationId, [
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
