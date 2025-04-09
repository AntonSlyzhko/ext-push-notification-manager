<?php

namespace Espo\Modules\PushNotificationManager\Classes\AppParams;

use Espo\Modules\PushNotificationManager\Tools\PushNotification\MetadataProvider;
use Espo\Tools\App\AppParam;

/**
 * @noinspection PhpUnused
 */
class AvailablePushNotificationProviders implements AppParam
{
    public function __construct(
        private MetadataProvider $metadataProvider
    ) {}

    /**
     * @return string[]
     */
    public function get(): array
    {
        return $this->metadataProvider->getAvailablePushNotificationProviders();
    }
}
