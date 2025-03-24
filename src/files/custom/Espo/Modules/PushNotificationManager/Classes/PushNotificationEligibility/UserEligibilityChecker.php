<?php

namespace Espo\Modules\PushNotificationManager\Classes\PushNotificationEligibility;

use Espo\Entities\User;

/**
 * Determines whether to send push notification to user via particular channel
 *
 * @noinspection PhpUnused
 */
interface UserEligibilityChecker
{
    public function check(User $user): bool;
}
