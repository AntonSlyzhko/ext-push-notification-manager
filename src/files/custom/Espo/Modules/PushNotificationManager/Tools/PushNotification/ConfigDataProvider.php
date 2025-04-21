<?php

namespace Espo\Modules\PushNotificationManager\Tools\PushNotification;

use Espo\Core\Utils\Config;

class ConfigDataProvider
{
    public function __construct(
        private MetadataProvider $metadataProvider,
        private Config $config
    ) {}

    /**
     * @return string[]
     */
    public function getAvailablePushNotificationProviders(): array
    {
        return array_values(array_filter(
            $this->config->get('availablePushNotificationProviders', []),
            fn(string $provider) => $this->metadataProvider->hasPushNotificationProvider($provider)
        ));
    }
}
