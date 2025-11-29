<?php

declare(strict_types=1);

namespace Tigusigalpa\YandexCloudClient\Laravel;

use Illuminate\Support\ServiceProvider;
use Tigusigalpa\YandexCloudClient\YandexCloudClient;

class YandexCloudServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/yandex-cloud.php',
            'yandex-cloud'
        );

        $this->app->singleton(YandexCloudClient::class, function ($app) {
            $oauthToken = config('yandex-cloud.oauth_token');

            if (empty($oauthToken)) {
                throw new \RuntimeException(
                    'Yandex Cloud OAuth token is not configured. ' .
                    'Please set YANDEX_CLOUD_OAUTH_TOKEN in your .env file.'
                );
            }

            return new YandexCloudClient($oauthToken);
        });

        $this->app->alias(YandexCloudClient::class, 'yandex-cloud');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/yandex-cloud.php' => config_path('yandex-cloud.php'),
            ], 'yandex-cloud-config');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            YandexCloudClient::class,
            'yandex-cloud',
        ];
    }
}
