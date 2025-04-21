<?php

namespace Espo\Modules\PushNotificationManager\Classes\PushNotification\Sender;

use Espo\Core\InjectableFactory;
use Espo\Modules\PushNotificationManager\Classes\PushNotification\Eligibility\Exceptions\MissingUserEligibilityCheckerException;
use Espo\Modules\PushNotificationManager\Tools\PushNotification\MetadataProvider;

class SenderFactory
{
    public function __construct(
        private MetadataProvider $metadataProvider,
        private InjectableFactory $injectableFactory
    ) {}

    public function create(string $provider): Sender
    {
        $className = $this->metadataProvider->getSenderImplementationClassName($provider);
        if (!$className) {
            throw new MissingUserEligibilityCheckerException($provider);
        }
        return $this->injectableFactory->create($className);
    }
}
