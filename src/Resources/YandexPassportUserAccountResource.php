<?php

declare(strict_types=1);

namespace Tigusigalpa\YandexCloudClient\Resources;

use Tigusigalpa\YandexCloudClient\Exceptions\ApiException;
use Tigusigalpa\YandexCloudClient\Exceptions\AuthenticationException;
use Tigusigalpa\YandexCloudClient\Exceptions\ValidationException;

/**
 * Yandex Passport User Account Resource
 * 
 * Get Yandex Passport user account information by login
 * @see https://yandex.cloud/ru/docs/iam/api-ref/YandexPassportUserAccount/
 */
class YandexPassportUserAccountResource extends AbstractResource
{
    private const BASE_URI = 'https://iam.api.cloud.yandex.net/iam/v1/yandexPassportUserAccounts';

    /**
     * Get user account by login
     *
     * @param string $login User login (Yandex Passport login)
     * @return array User account information including ID
     * @throws ApiException
     * @throws AuthenticationException
     * @throws ValidationException
     */
    public function getByLogin(string $login): array
    {
        if (empty($login)) {
            throw new ValidationException('Login is required');
        }

        return $this->makeRequest('GET', self::BASE_URI . ':byLogin', [
            'query' => ['login' => $login],
        ]);
    }
}
