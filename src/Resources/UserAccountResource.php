<?php

declare(strict_types=1);

namespace Tigusigalpa\YandexCloudClient\Resources;

use Tigusigalpa\YandexCloudClient\Exceptions\ApiException;
use Tigusigalpa\YandexCloudClient\Exceptions\AuthenticationException;
use Tigusigalpa\YandexCloudClient\Exceptions\ValidationException;

/**
 * User Account Resource
 * 
 * Get user account information
 * @see https://yandex.cloud/ru/docs/iam/api-ref/UserAccount/
 */
class UserAccountResource extends AbstractResource
{
    private const BASE_URI = 'https://iam.api.cloud.yandex.net/iam/v1/userAccounts';

    /**
     * Get user account by ID
     *
     * @param string $userAccountId User account ID
     * @return array User account information
     * @throws ApiException
     * @throws AuthenticationException
     * @throws ValidationException
     */
    public function get(string $userAccountId): array
    {
        if (empty($userAccountId)) {
            throw new ValidationException('User account ID is required');
        }

        return $this->makeRequest('GET', self::BASE_URI . '/' . $userAccountId);
    }
}
