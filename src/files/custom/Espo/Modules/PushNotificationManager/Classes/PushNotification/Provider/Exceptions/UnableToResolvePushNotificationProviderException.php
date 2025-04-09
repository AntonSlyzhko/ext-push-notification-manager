<?php

namespace Espo\Modules\PushNotificationManager\Classes\PushNotification\Provider\Exceptions;

use RuntimeException;

class UnableToResolvePushNotificationProviderException extends RuntimeException
{
    public function __construct(string $message = "Unable to resolve push notification provider")
    {
        parent::__construct($message);
    }
}
