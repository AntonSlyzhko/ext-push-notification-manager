<?php

namespace Espo\Modules\PushNotificationManager\Classes\PushNotification\Provider;

use Espo\Entities\Preferences;
use Espo\Modules\PushNotificationManager\Classes\PushNotification\Provider\Exceptions\UnableToResolvePushNotificationProviderException;
use Espo\Modules\PushNotificationManager\Tools\PushNotification\MetadataProvider;

class DefaultProviderResolver implements ProviderResolver
{
    public function __construct(
        private MetadataProvider $metadataProvider,
        private ?Preferences $preferences
    ) {}

    public function resolve(): string
    {
        $defaultProvider = $this->preferences?->get('defaultPushNotificationProvider');
        $providers = $this->metadataProvider->getAvailablePushNotificationProviders();

        if (!$providers) {
            throw new UnableToResolvePushNotificationProviderException();
        }

        return ($defaultProvider && in_array($defaultProvider, $providers))
            ? $defaultProvider
            : $providers[0];
    }
}
