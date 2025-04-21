<?php

namespace Espo\Modules\PushNotificationManager\Classes\PushNotification\Eligibility\Exceptions;

use RuntimeException;

class MissingUserEligibilityCheckerException extends RuntimeException
{
    public function __construct(string $provider)
    {
        parent::__construct("Missing UserEligibilityChecker implementation class for provider '$provider'.");
    }
}
