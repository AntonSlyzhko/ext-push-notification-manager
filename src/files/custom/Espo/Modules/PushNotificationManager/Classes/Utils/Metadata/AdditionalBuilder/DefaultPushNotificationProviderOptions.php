<?php

namespace Espo\Modules\PushNotificationManager\Classes\Utils\Metadata\AdditionalBuilder;

use Espo\Core\Utils\Metadata\AdditionalBuilder;
use stdClass;

/**
 * @noinspection PhpUnused
 */
class DefaultPushNotificationProviderOptions implements AdditionalBuilder
{
    public function build(stdClass $data): void
    {
        if (
            !isset($data->entityDefs?->Preferences?->fields?->defaultPushNotificationProvider) ||
            !isset($data->app?->pushNotificationProviders)
        ) {
            return;
        }

        /** @var array<string, stdClass> $providers */
        $providers = get_object_vars($data->app->pushNotificationProviders);

        uasort(
            $providers,
            fn(stdClass $a, stdClass $b): int =>
                ($a->order ?? PHP_INT_MAX) <=> ($b->order ?? PHP_INT_MAX)
        );

        $data->entityDefs->Preferences->fields->defaultPushNotificationProvider->options = array_keys($providers);
    }
}
