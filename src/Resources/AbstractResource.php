<?php

declare(strict_types=1);

namespace Tigusigalpa\YandexCloudClient\Resources;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Tigusigalpa\YandexCloudClient\Auth\IamTokenManager;
use Tigusigalpa\YandexCloudClient\Exceptions\ApiException;
use Tigusigalpa\YandexCloudClient\Exceptions\AuthenticationException;

abstract class AbstractResource
{
    protected ClientInterface $httpClient;
    protected IamTokenManager $authManager;

    public function __construct(ClientInterface $httpClient, IamTokenManager $authManager)
    {
        $this->httpClient = $httpClient;
        $this->authManager = $authManager;
    }

    /**
     * Make HTTP request to Yandex Cloud API
     *
     * @param string $method HTTP method
     * @param string $uri Request URI
     * @param array $options Request options
     * @return array Response data
     * @throws ApiException
     * @throws AuthenticationException
     */
    protected function makeRequest(string $method, string $uri, array $options = []): array
    {
        try {
            // Get valid IAM token
            $iamToken = $this->authManager->getValidIamToken();

            // Add authorization header to request options
            $options['headers'] = array_merge(
                $options['headers'] ?? [],
                ['Authorization' => 'Bearer ' . $iamToken]
            );

            $response = $this->httpClient->request($method, $uri, $options);
            return $this->parseResponse($response);
        } catch (AuthenticationException $e) {
            throw $e;
        } catch (GuzzleException $e) {
            throw new ApiException(
                'HTTP request failed: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Parse HTTP response
     *
     * @param ResponseInterface $response
     * @return array
     * @throws ApiException
     */
    private function parseResponse(ResponseInterface $response): array
    {
        $body = $response->getBody()->getContents();
        $statusCode = $response->getStatusCode();

        if ($statusCode >= 400) {
            throw new ApiException(
                'API request failed with status ' . $statusCode . ': ' . $body,
                $statusCode
            );
        }

        // Handle empty responses
        if (empty($body)) {
            return [];
        }

        $data = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ApiException(
                'Failed to parse JSON response: ' . json_last_error_msg()
            );
        }

        return $data ?? [];
    }

    /**
     * Build query string from parameters
     *
     * @param array $params
     * @return string
     */
    protected function buildQueryString(array $params): string
    {
        $filtered = array_filter($params, fn($value) => $value !== null);
        return empty($filtered) ? '' : '?' . http_build_query($filtered);
    }
}
