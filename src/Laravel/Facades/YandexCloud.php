<?php

declare(strict_types=1);

namespace Tigusigalpa\YandexCloudClient\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use Tigusigalpa\YandexCloudClient\Resources\CloudResource;
use Tigusigalpa\YandexCloudClient\Resources\FolderResource;
use Tigusigalpa\YandexCloudClient\Resources\OrganizationResource;
use Tigusigalpa\YandexCloudClient\Resources\RefreshTokenResource;

/**
 * @method static OrganizationResource organizations()
 * @method static CloudResource clouds()
 * @method static FolderResource folders()
 * @method static RefreshTokenResource refreshTokens()
 * @method static string getOauthToken()
 *
 * @see \Tigusigalpa\YandexCloudClient\YandexCloudClient
 */
class YandexCloud extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'yandex-cloud';
    }
}
