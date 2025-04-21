<?php

namespace Espo\Modules\PushNotificationManager\Classes\PushNotification\Sender\Exceptions;

use RuntimeException;

class MissingSenderException extends RuntimeException
{
    public function __construct(string $provider)
    {
        parent::__construct("Missing Sender implementation class for provider '$provider'.");
    }
}
