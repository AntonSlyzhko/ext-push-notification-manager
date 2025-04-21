<?php

namespace Espo\Modules\PushNotificationManager\Classes\PushNotification\Eligibility;

use Espo\Entities\User;

/**
 * Determines whether to send push notification to user via a particular channel
 *
 * @noinspection PhpUnused
 */
interface UserEligibilityChecker
{
    public function check(User $user): bool;
}
