<?php

declare(strict_types=1);

namespace Tigusigalpa\YandexCloudClient\Resources;

use Tigusigalpa\YandexCloudClient\Exceptions\ApiException;
use Tigusigalpa\YandexCloudClient\Exceptions\ValidationException;

/**
 * RefreshToken API resource
 * @see https://yandex.cloud/ru/docs/iam/api-ref/RefreshToken/
 */
class RefreshTokenResource extends AbstractResource
{
    /**
     * Get list of refresh tokens
     *
     * @param int|null $pageSize Maximum number of results per page
     * @param string|null $pageToken Page token for pagination
     * @return array
     * @throws ApiException
     * @see https://yandex.cloud/ru/docs/iam/api-ref/RefreshToken/list
     */
    public function list(?int $pageSize = null, ?string $pageToken = null): array
    {
        $query = $this->buildQueryString([
            'pageSize' => $pageSize,
            'pageToken' => $pageToken,
        ]);

        return $this->makeRequest('GET', 'iam/v1/refreshTokens' . $query);
    }

    /**
     * Revoke refresh token
     *
     * @param string $refreshTokenId Refresh token ID
     * @return array
     * @throws ApiException
     * @throws ValidationException
     * @see https://yandex.cloud/ru/docs/iam/api-ref/RefreshToken/revoke
     */
    public function revoke(string $refreshTokenId): array
    {
        if (empty($refreshTokenId)) {
            throw new ValidationException('Refresh token ID cannot be empty');
        }

        return $this->makeRequest('POST', "iam/v1/refreshTokens/{$refreshTokenId}:revoke");
    }
}
