<?php

namespace Espo\Modules\PushNotificationManager\Classes\AppParams;

use Espo\Modules\PushNotificationManager\Tools\PushNotification\ConfigDataProvider;
use Espo\Tools\App\AppParam;

/**
 * @noinspection PhpUnused
 */
class AvailablePushNotificationProviders implements AppParam
{
    public function __construct(
        private ConfigDataProvider $configDataProvider
    ) {}

    /**
     * @return string[]
     */
    public function get(): array
    {
        return $this->configDataProvider->getAvailablePushNotificationProviders();
    }
}
