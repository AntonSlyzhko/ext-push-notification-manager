<?php

namespace Espo\Modules\PushNotificationManager\Classes\Jobs;

use Espo\Core\Job\JobDataLess;
use Espo\Modules\PushNotificationManager\Tools\PushNotification\Dispatcher;

/**
 * @noinspection PhpUnused
 */
class SendPushNotifications implements JobDataLess
{
    public function __construct(
        private readonly Dispatcher $dispatcher
    ) {}

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        $this->dispatcher->processBatch();
    }
}
