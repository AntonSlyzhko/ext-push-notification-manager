<?php

namespace Espo\Modules\PushNotificationManager\Tools\PushNotification\Exceptions;

use Exception;

class ProviderNotFoundException extends Exception {
    public function __construct(string $provider) {
        parent::__construct("Push notification provider '$provider' not found.");
    }
}
