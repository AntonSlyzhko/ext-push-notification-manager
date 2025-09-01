<?php

namespace Espo\Modules\PushNotificationManager\Tools\PushNotification;

use Espo\Core\Utils\Metadata;
use Espo\Modules\PushNotificationManager\Classes\PushNotification\Eligibility\UserEligibilityChecker;
use Espo\Modules\PushNotificationManager\Classes\PushNotification\Provider\ProviderResolver;
use Espo\Modules\PushNotificationManager\Classes\PushNotification\Sender\Sender as Sender;

final class MetadataProvider
{
    public function __construct(
        private readonly Metadata $metadata
    ) {}

    /**
     * @return string[]
     */
    public function getPushNotificationProviders(): array
    {
        /** @var array<string, array<string, mixed>> $providers */
        $providers = $this->metadata->get('app.pushNotificationProviders', []);

        uasort(
            $providers,
            fn(array $a, array $b): int =>
                ($a['order'] ?? PHP_INT_MAX) <=> ($b['order'] ?? PHP_INT_MAX)
        );

        return array_keys($providers);
    }

    public function hasPushNotificationProvider(string $provider): bool
    {
        return in_array($provider, $this->getPushNotificationProviders(), true);
    }

    /**
     * @return ?class-string<Sender>
     */
    public function getSenderImplementationClassName(string $provider): ?string
    {
        return $this->metadata->get("app.pushNotificationProviders.$provider.senderImplementationClassName");
    }

    /**
     * @return ?class-string<UserEligibilityChecker>
     */
    public function getUserEligibilityCheckerImplementationClassName(string $provider): ?string
    {
        return $this->metadata->get("app.pushNotificationProviders.$provider.userEligibilityCheckerImplementationClassName");
    }

    /**
     * @return ?class-string<ProviderResolver>
     */
    public function getProviderResolverImplementationClassName(): ?string
    {
        return $this->metadata->get("app.pushNotificationProviders.providerResolverImplementationClassName");
    }
}
