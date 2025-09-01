<?php

namespace Espo\Modules\PushNotificationManager\Classes\PushNotification\Provider;

interface ProviderResolver
{
    public function resolve(): string;
}
