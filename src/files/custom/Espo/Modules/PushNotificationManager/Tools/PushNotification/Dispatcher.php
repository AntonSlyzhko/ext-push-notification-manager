<?php

namespace Espo\Modules\PushNotificationManager\Tools\PushNotification;

use Espo\Core\Exceptions\NotFound;
use Espo\Core\Name\Field;
use Espo\Core\Utils\DateTime;
use Espo\Core\Utils\Log;
use Espo\Entities\User;
use Espo\Modules\PushNotificationManager\Classes\PushNotification\Eligibility\UserEligibilityCheckerFactory;
use Espo\Modules\PushNotificationManager\Classes\PushNotification\Provider\ProviderResolverFactory;
use Espo\Modules\PushNotificationManager\Classes\PushNotification\Sender\SenderFactory;
use Espo\Modules\PushNotificationManager\Entities\PushNotification;
use Espo\Modules\PushNotificationManager\Tools\PushNotification\Exceptions\InvalidStateException;
use Espo\Modules\PushNotificationManager\Tools\PushNotification\Exceptions\ProviderNotFoundException;
use Espo\Modules\PushNotificationManager\Tools\PushNotification\Exceptions\ProviderNotResolvedException;
use Espo\Modules\PushNotificationManager\Tools\PushNotification\Exceptions\SendingException;
use Espo\Modules\PushNotificationManager\Tools\PushNotification\Exceptions\UserNotEligibleException;
use Espo\Modules\PushNotificationManager\Tools\PushNotification\Exceptions\UserNotFoundException;
use Espo\ORM\EntityManager;
use Espo\ORM\Query\Part\Condition;
use ReflectionException;
use Throwable;

class Dispatcher
{
    private const DEFAULT_BATCH_SIZE = 100;

    public function __construct(
        private readonly EntityManager $entityManager,
        private readonly MetadataProvider $metadataProvider,
        private readonly UserEligibilityCheckerFactory $userEligibilityCheckerFactory,
        private readonly ProviderResolverFactory $providerResolverFactory,
        private readonly SenderFactory $senderFactory,
        private readonly Log $log
    ) {}

    public function processBatch(): void
    {
        $pushNotifications = $this->entityManager
            ->getRDBRepositoryByClass(PushNotification::class)
            ->where(
                Condition::equal(
                    Condition::column(PushNotification::ATTRIBUTE_STATUS),
                    PushNotification::STATUS_CREATED
                )
            )
            ->order(Field::CREATED_AT)
            ->limit(0, self::DEFAULT_BATCH_SIZE)
            ->sth()
            ->find();

        foreach ($pushNotifications as $pushNotification) {
            try {
                $this->processOne($pushNotification);
            } catch (Throwable $e) {
                $this->log->error(
                    sprintf(
                        "PushNotification %s failed during batch processing. Reason: %s",
                        $pushNotification->getId(),
                        $e->getMessage()
                    ),
                    [
                        'notificationId' => $pushNotification->getId(),
                        'failReason' => $pushNotification->getFailReason(),
                        'exception' => $e,
                    ]
                );
            }
        }
    }

    /**
     * @throws ReflectionException
     * @throws NotFound
     * @throws InvalidStateException
     * @throws Throwable
     */
    public function processOne(PushNotification $pushNotification): void
    {
        try {
            if ($pushNotification->getStatus() === PushNotification::STATUS_CREATED) {
                throw new InvalidStateException("PushNotification is not in primary status.");
            }

            $provider = $this->getProvider($pushNotification);
            $this->send($provider, $pushNotification);

            $pushNotification
                ->setStatus(PushNotification::STATUS_SENT)
                ->setSentAt(DateTime::getSystemNowString());

            $this->entityManager->saveEntity($pushNotification);
        } catch (Throwable $e) {
            $failReason = match ($e::class) {
                InvalidStateException::class => PushNotification::FAIL_REASON_INVALID_STATE,
                ProviderNotFoundException::class => PushNotification::FAIL_REASON_PROVIDER_NOT_FOUND,
                UserNotFoundException::class => PushNotification::FAIL_REASON_USER_NOT_FOUND,
                ProviderNotResolvedException::class => PushNotification::FAIL_REASON_PROVIDER_NOT_RESOLVED,
                UserNotEligibleException::class => PushNotification::FAIL_REASON_USER_NOT_ELIGIBLE,
                SendingException::class => PushNotification::FAIL_REASON_SEND_ERROR,
                default => PushNotification::FAIL_REASON_UNEXPECTED_ERROR
            };

            $pushNotification
                ->setStatus(PushNotification::STATUS_FAILED)
                ->setFailReason($failReason);
            $this->entityManager->saveEntity($pushNotification);

            throw $e;
        }
    }

    /**
     * @throws ReflectionException
     * @throws ProviderNotFoundException
     * @throws UserNotFoundException
     * @throws UserNotEligibleException
     * @throws ProviderNotResolvedException
     */
    private function getProvider(PushNotification $pushNotification): string
    {
        $provider = $pushNotification->getProvider();
        if ($provider) {
            $this->checkProviderExists($provider);

            return $provider;
        }

        /** @var ?User $user */
        $user = null;

        $userId = $pushNotification->getUserId();
        if ($userId) {
            $user = $this->entityManager
                ->getRDBRepositoryByClass(User::class)
                ->getById($userId);

            if (!$user) {
                throw new UserNotFoundException($userId);
            }
        }

        if (!$user) {
            throw new ProviderNotResolvedException("Not enough data to resolve push notification provider.");
        }

        $providerResolver = $this->providerResolverFactory->createForUser($user);
        try {
            $provider = $providerResolver->resolve();
        } catch (Throwable $e) {
            throw new ProviderNotResolvedException("Resolver failed.", $e);
        }

        $this->checkProviderExists($provider);
        $this->checkUserEligibility($user, $provider);

        return $provider;
    }

    /**
     * @throws ReflectionException
     * @throws SendingException
     */
    private function send(string $provider, PushNotification $pushNotification): void
    {
        $sender = $this->senderFactory->create($provider);

        try {
            $sender->send($pushNotification);
        } catch (Throwable $e) {
            throw new SendingException("Sending failed.", $e);
        }
    }

    /**
     * @throws ProviderNotFoundException
     */
    private function checkProviderExists(string $provider): void
    {
        if ($this->metadataProvider->hasPushNotificationProvider($provider)) {
            return;
        }

        throw new ProviderNotFoundException($provider);
    }

    /**
     * @throws UserNotEligibleException
     * @throws ReflectionException
     */
    private function checkUserEligibility(User $user, string $provider): void
    {
        $userEligibilityChecker = $this->userEligibilityCheckerFactory->create($provider);
        if ($userEligibilityChecker->check($user)) {
            return;
        }

        throw new UserNotEligibleException($user->getId(), $provider);
    }
}
