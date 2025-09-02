<?php

namespace Espo\Modules\PushNotificationManager\Tools\PushNotification\Exceptions;

use Exception;

class UserNotFoundException extends Exception {
    public function __construct(string $userId) {
        parent::__construct("User $userId does not exist.");
    }
}
