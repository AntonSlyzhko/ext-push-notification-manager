<?php

namespace Espo\Modules\PushNotificationManager\Classes\PushNotification\Provider;

use Espo\Entities\Preferences;
use Espo\Modules\PushNotificationManager\Tools\PushNotification\MetadataProvider;
use RuntimeException;

class DefaultProviderResolver implements ProviderResolver
{
    public function __construct(
        private readonly MetadataProvider $metadataProvider,
        private readonly ?Preferences $preferences
    ) {}

    public function resolve(): string
    {
        $defaultProvider = $this->preferences?->get('defaultPushNotificationProvider');
        $providers = $this->metadataProvider->getPushNotificationProviders();

        if (!$providers) {
            throw new RuntimeException("Unable to resolve push notification provider");
        }

        return ($defaultProvider && in_array($defaultProvider, $providers))
            ? $defaultProvider
            : $providers[0];
    }
}
