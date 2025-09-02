<?php

namespace Espo\Modules\PushNotificationManager\Tools\PushNotification\Exceptions;

use Exception;

class UserNotEligibleException extends Exception {
    public function __construct(string $userId, string $provider) {
        parent::__construct("User $userId is not eligible for push notification provider '$provider'");
    }
}
