<?php

namespace Espo\Modules\PushNotificationManager\Classes\PushNotification\Sender;

use Espo\Modules\PushNotificationManager\Entities\PushNotification;

interface Sender
{
    public function send(PushNotification $pushNotification);
}
