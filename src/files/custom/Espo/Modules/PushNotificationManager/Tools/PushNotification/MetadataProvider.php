<?php

namespace Espo\Modules\PushNotificationManager\Tools\PushNotification;

use Espo\Core\Utils\Metadata;
use Espo\Modules\PushNotificationManager\Classes\PushNotification\Eligibility\UserEligibilityChecker;
use Espo\Modules\PushNotificationManager\Classes\PushNotification\Provider\ProviderResolver;
use Espo\Modules\PushNotificationManager\Classes\PushNotification\Sender\Sender as Sender;

class MetadataProvider
{
    /** @var ?string[] */
    private ?array $pushNotificationProvidersCache = null;
    /** @var array<string, ?class-string> */
    private array $senderImplementationClassNameCache = [];
    /** @var array<string, ?class-string> */
    private array $userEligibilityCheckerImplementationClassNameCache = [];
    /** @var ?class-string<ProviderResolver> */
    private ?string $providerResolverImplementationClassNameCache;

    public function __construct(
        private Metadata $metadata
    ) {}

    /**
     * @return string[]
     */
    private function getPushNotificationProviders(): array
    {
        if ($this->pushNotificationProvidersCache === null) {
            $this->pushNotificationProvidersCache = array_keys(
                $this->metadata->get('app.pushNotificationProviders', [])
            );
        }
        return $this->pushNotificationProvidersCache;
    }

    public function hasPushNotificationProvider(string $provider): bool
    {
        return in_array($provider, $this->getPushNotificationProviders());
    }

    /**
     * @return ?class-string<Sender>
     */
    public function getSenderImplementationClassName(string $provider): ?string
    {
        if (!array_key_exists($provider, $this->senderImplementationClassNameCache)) {
            $this->senderImplementationClassNameCache[$provider] = $this->metadata->get("app.pushNotificationProviders.$provider.senderImplementationClassName");
        }

        return $this->senderImplementationClassNameCache[$provider];
    }

    /**
     * @return ?class-string<UserEligibilityChecker>
     */
    public function getUserEligibilityCheckerImplementationClassName(string $provider): ?string
    {
        if (!array_key_exists($provider, $this->userEligibilityCheckerImplementationClassNameCache)) {
            $this->userEligibilityCheckerImplementationClassNameCache[$provider] = $this->metadata->get("app.pushNotificationProviders.$provider.userEligibilityCheckerImplementationClassName");
        }

        return $this->userEligibilityCheckerImplementationClassNameCache[$provider];
    }

    /**
     * @return ?class-string<ProviderResolver>
     */
    public function getProviderResolverImplementationClassName(): ?string
    {
        if (!isset($this->providerResolverImplementationClassNameCache)) {
            $this->providerResolverImplementationClassNameCache = $this->metadata->get("app.pushNotificationProviders.providerResolverImplementationClassName");
        }
        return $this->providerResolverImplementationClassNameCache;
    }
}
