<?php

declare(strict_types=1);

namespace Tigusigalpa\YandexCloudClient\Auth;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Tigusigalpa\YandexCloudClient\Exceptions\AuthenticationException;

/**
 * Manages IAM token lifecycle including caching and auto-refresh
 */
class IamTokenManager
{
    private const IAM_TOKEN_ENDPOINT = 'https://iam.api.cloud.yandex.net/iam/v1/tokens';
    private const TOKEN_LIFETIME = 43200; // 12 hours in seconds
    private const TOKEN_REFRESH_MARGIN = 300; // 5 minutes in seconds

    private ClientInterface $httpClient;
    private string $oauthToken;
    private ?string $iamToken = null;
    private ?int $iamTokenExpiry = null;

    public function __construct(string $oauthToken, ?ClientInterface $httpClient = null)
    {
        if (empty($oauthToken)) {
            throw new AuthenticationException('OAuth token cannot be empty');
        }

        $this->oauthToken = $oauthToken;
        $this->httpClient = $httpClient ?? new Client([
            'timeout' => 30,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * Get valid IAM token (with auto-refresh)
     *
     * @return string
     * @throws AuthenticationException
     */
    public function getValidIamToken(): string
    {
        // Check if token needs refresh (tokens are valid for 12 hours)
        if ($this->iamToken === null || $this->iamTokenExpiry === null || time() >= $this->iamTokenExpiry) {
            $this->refreshIamToken();
        }

        return $this->iamToken;
    }

    /**
     * Get IAM token using OAuth token
     *
     * @return string
     * @throws AuthenticationException
     */
    public function getIamToken(): string
    {
        try {
            $response = $this->httpClient->post(self::IAM_TOKEN_ENDPOINT, [
                'json' => [
                    'yandexPassportOauthToken' => $this->oauthToken,
                ],
            ]);

            $statusCode = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();

            if ($statusCode !== 200) {
                $errorData = json_decode($responseBody, true);
                $errorMessage = $errorData['message'] ?? 'Unknown error';
                throw new AuthenticationException("Failed to get IAM token (HTTP {$statusCode}): {$errorMessage}");
            }

            $data = json_decode($responseBody, true);

            if (!isset($data['iamToken'])) {
                throw new AuthenticationException('IAM token not found in response');
            }

            return $data['iamToken'];
        } catch (GuzzleException $e) {
            throw new AuthenticationException('Error getting IAM token: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Refresh IAM token
     *
     * @throws AuthenticationException
     */
    private function refreshIamToken(): void
    {
        $this->iamToken = $this->getIamToken();
        // IAM tokens are valid for 12 hours, set expiry with 5 minute margin
        $this->iamTokenExpiry = time() + self::TOKEN_LIFETIME - self::TOKEN_REFRESH_MARGIN;
    }

    /**
     * Clear cached IAM token (force refresh on next request)
     */
    public function clearCache(): void
    {
        $this->iamToken = null;
        $this->iamTokenExpiry = null;
    }

    /**
     * Check if cached IAM token is still valid
     *
     * @return bool
     */
    public function hasValidCachedToken(): bool
    {
        return $this->iamToken !== null
            && $this->iamTokenExpiry !== null
            && time() < $this->iamTokenExpiry;
    }

    /**
     * Get OAuth token (for debugging purposes)
     *
     * @return string
     */
    public function getOAuthToken(): string
    {
        return $this->oauthToken;
    }
}
