<?php

namespace Espo\Modules\PushNotificationManager\Tools\PushNotification;

use Espo\Core\Utils\Config;

class ConfigDataProvider
{
    /** @var ?string[] */
    private ?array $availablePushNotificationProvidersCache = null;

    public function __construct(
        private MetadataProvider $metadataProvider,
        private Config $config
    ) {}

    /**
     * @return string[]
     */
    public function getAvailablePushNotificationProviders(): array
    {
        if ($this->availablePushNotificationProvidersCache === null) {
            $this->availablePushNotificationProvidersCache = array_values(array_filter(
                $this->config->get('availablePushNotificationProviders', []),
                fn(string $provider) => $this->metadataProvider->hasPushNotificationProvider($provider)
            ));
        }
        return $this->availablePushNotificationProvidersCache;
    }

    public function isPushNotificationProviderAvailable(string $provider): bool
    {
        return in_array($provider, $this->getAvailablePushNotificationProviders());
    }
}
