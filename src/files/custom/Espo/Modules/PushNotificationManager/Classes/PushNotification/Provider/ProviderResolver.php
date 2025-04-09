<?php

namespace Espo\Modules\PushNotificationManager\Classes\PushNotification\Provider;

/**
 * Resolves a push notification provider. A preferences to be passed to the constructor.
 */
interface ProviderResolver
{
    public function resolve(): string;
}
