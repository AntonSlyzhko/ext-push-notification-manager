<?php

namespace Espo\Modules\PushNotificationManager\Classes\PushNotification\Provider;

use Espo\Core\Binding\Binder;
use Espo\Core\Binding\BindingContainer;
use Espo\Core\Binding\BindingData;
use Espo\Core\InjectableFactory;
use Espo\Entities\Preferences;
use Espo\Entities\User;
use Espo\Modules\PushNotificationManager\Tools\PushNotification\MetadataProvider;
use Espo\ORM\EntityManager;
use Espo\ORM\Name\Attribute;
use Espo\ORM\Query\Part\Condition;

class ProviderResolverFactory
{
    public function __construct(
        private InjectableFactory $injectableFactory,
        private MetadataProvider $metadataProvider,
        private EntityManager $entityManager
    ) {}

    public function create(User $user): ProviderResolver
    {
        $className = $this->getClassName();

        $preferences = $this->entityManager
            ->getRDBRepositoryByClass(Preferences::class)
            ->where(
                Condition::equal(
                    Condition::column(Attribute::ID),
                    $user->getId()
                )
            )
            ->findOne();

        $bindingData = new BindingData();
        $binder = new Binder($bindingData);
        $binder
            ->for($className)
            ->bindValue('$preferences', $preferences);

        return $this->injectableFactory->createWithBinding($className, new BindingContainer($bindingData));
    }

    /**
     * @return class-string<ProviderResolver>
     */
    private function getClassName(): string
    {
        return $this->metadataProvider->getProviderResolverImplementationClassName() ??
            DefaultProviderResolver::class;
    }
}
