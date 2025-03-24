<?php

namespace Espo\Modules\PushNotificationManager\Classes\PushNotificationSender;

use Espo\Modules\PushNotificationManager\Entities\PushNotification;

/**
 * @noinspection PhpUnused
 */
interface Sender
{
    public function send(PushNotification $pushNotification);
}
