<?php

namespace Espo\Modules\PushNotificationManager\Tools\PushNotification\Exceptions;

use Exception;
use Throwable;

class ProviderNotResolvedException extends Exception {
    public function __construct(string $message = "", Throwable $previous = null)
    {
        parent::__construct($message ?: "Failed to resolve provider.", 0, $previous);
    }
}
