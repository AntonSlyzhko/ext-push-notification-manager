<?php

namespace Espo\Modules\PushNotificationManager\Classes\PushNotification\Provider;

/**
 * Resolves a push notification provider. A preference to be passed to the constructor.
 */
interface ProviderResolver
{
    public function resolve(): string;
}
