<?php

namespace Espo\Modules\PushNotificationManager\Classes\PushNotification\Sender;

use Espo\Core\InjectableFactory;
use Espo\Modules\PushNotificationManager\Tools\PushNotification\MetadataProvider;
use ReflectionClass;
use ReflectionException;
use RuntimeException;

class SenderFactory
{
    public function __construct(
        private MetadataProvider $metadataProvider,
        private InjectableFactory $injectableFactory
    ) {}

    /**
     * @throws ReflectionException
     * @throws RuntimeException
     */
    public function create(string $provider): Sender
    {
        $className = $this->metadataProvider->getSenderImplementationClassName($provider);
        if (!$className) {
            throw new RuntimeException("Missing Sender implementation class for provider '$provider'.");
        }

        $class = new ReflectionClass($className);
        if (!$class->implementsInterface(Sender::class)) {
            throw new RuntimeException("Class '$className' does not implement 'Sender' interface.");
        }

        return $this->injectableFactory->create($className);
    }
}
