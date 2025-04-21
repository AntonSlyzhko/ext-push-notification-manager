<?php

namespace Espo\Modules\PushNotificationManager\Classes\PushNotification\Eligibility;

use Espo\Core\InjectableFactory;
use Espo\Modules\PushNotificationManager\Classes\PushNotification\Eligibility\Exceptions\MissingUserEligibilityCheckerException;
use Espo\Modules\PushNotificationManager\Tools\PushNotification\MetadataProvider;

class UserEligibilityCheckerFactory
{
    public function __construct(
        private InjectableFactory $injectableFactory,
        private MetadataProvider $metadataProvider
    ) {}

    public function create(string $provider): UserEligibilityChecker
    {
        $className = $this->metadataProvider->getUserEligibilityCheckerImplementationClassName($provider);
        if (!$className) {
            throw new MissingUserEligibilityCheckerException($provider);
        }
        return $this->injectableFactory->create($className);
    }
}
