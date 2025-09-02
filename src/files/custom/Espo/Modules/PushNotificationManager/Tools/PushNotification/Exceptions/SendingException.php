<?php

namespace Espo\Modules\PushNotificationManager\Tools\PushNotification\Exceptions;

use Exception;
use Throwable;

class SendingException extends Exception {
    public function __construct(string $message = "", Throwable $previous = null)
    {
        parent::__construct($message ?: "Failed to send push notification.", 0, $previous);
    }
}
