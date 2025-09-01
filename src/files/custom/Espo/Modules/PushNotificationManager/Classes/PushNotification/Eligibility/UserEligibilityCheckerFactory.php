<?php

namespace Espo\Modules\PushNotificationManager\Classes\PushNotification\Eligibility;

use Espo\Core\InjectableFactory;
use Espo\Modules\PushNotificationManager\Tools\PushNotification\MetadataProvider;
use ReflectionClass;
use ReflectionException;
use RuntimeException;

class UserEligibilityCheckerFactory
{
    public function __construct(
        private InjectableFactory $injectableFactory,
        private MetadataProvider $metadataProvider
    ) {}

    /**
     * @throws ReflectionException
     */
    public function create(string $provider): UserEligibilityChecker
    {
        $className = $this->metadataProvider->getUserEligibilityCheckerImplementationClassName($provider);
        if (!$className) {
            throw new RuntimeException("Missing UserEligibilityChecker implementation class for provider '$provider'.");
        }

        $class = new ReflectionClass($className);
        if (!$class->implementsInterface(UserEligibilityChecker::class)) {
            throw new RuntimeException("Class '$className' does not implement 'UserEligibilityChecker' interface.");
        }

        return $this->injectableFactory->create($className);
    }
}
