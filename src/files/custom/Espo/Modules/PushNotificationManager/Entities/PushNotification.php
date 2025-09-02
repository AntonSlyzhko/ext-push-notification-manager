<?php

namespace Espo\Modules\PushNotificationManager\Entities;

use Espo\Core\Field\LinkParent;
use Espo\Core\Name\Field;
use Espo\Core\ORM\Entity;
use stdClass;

class PushNotification extends Entity
{
    public const ENTITY_TYPE = 'PushNotification';
    public const ATTRIBUTE_PROVIDER = 'provider';
    public const ATTRIBUTE_TEMPLATE_DATA = 'templateData';
    public const ATTRIBUTE_DATA = 'data';
    public const ATTRIBUTE_SENT_AT = 'sentAt';
    public const ATTRIBUTE_STATUS = 'status';
    public const ATTRIBUTE_FAIL_REASON = 'failReason';
    public const LINK_PUSH_NOTIFICATION_TEMPLATE = 'pushNotificationTemplate';
    public const LINK_USER = 'user';
    public const STATUS_CREATED = 'Created';
    public const STATUS_SENT = 'Sent';
    public const STATUS_FAILED = 'Failed';
    public const FAIL_REASON_INVALID_STATE = 'InvalidState';
    public const FAIL_REASON_PROVIDER_NOT_FOUND = 'ProviderNotFound';
    public const FAIL_REASON_USER_NOT_FOUND = 'UserNotFound';
    public const FAIL_REASON_PROVIDER_NOT_RESOLVED = 'ProviderNotResolved';
    public const FAIL_REASON_USER_NOT_ELIGIBLE = 'UserNotEligible';
    public const FAIL_REASON_SEND_ERROR = 'SendError';
    public const FAIL_REASON_UNEXPECTED_ERROR = 'UnexpectedError';

    public function getName(): ?string
    {
        return $this->get(Field::NAME);
    }

    public function setName(?string $name): static
    {
        return $this->set(Field::NAME, $name);
    }

    public function getProvider(): ?string
    {
        return $this->get(self::ATTRIBUTE_PROVIDER);
    }

    public function setProvider(string $provider): static
    {
        return $this->set(self::ATTRIBUTE_PROVIDER, $provider);
    }

    public function getPushNotificationTemplateId(): ?string
    {
        return $this->get(self::LINK_PUSH_NOTIFICATION_TEMPLATE. 'Id');
    }

    public function setPushNotificationTemplate(?string $pushNotificationTemplateId): static
    {
        return $this->set(self::LINK_PUSH_NOTIFICATION_TEMPLATE. 'Id', $pushNotificationTemplateId);
    }

    public function getTemplateData(): stdClass
    {
        return $this->get(self::ATTRIBUTE_TEMPLATE_DATA) ?? (object) [];
    }

    /**
     * @param stdClass|array<string, mixed> $data
     */
    public function setTemplateData(stdClass|array $data): static
    {
        return $this->set(self::ATTRIBUTE_TEMPLATE_DATA, $data);
    }

    public function getData(): stdClass
    {
        return $this->get(self::ATTRIBUTE_DATA) ?? (object) [];
    }

    /**
     * @param stdClass|array<string, mixed> $data
     */
    public function setData(stdClass|array $data): static
    {
        return $this->set(self::ATTRIBUTE_DATA, $data);
    }

    public function getUserId(): ?string
    {
        return $this->get(self::LINK_USER. 'Id');
    }

    public function setUserId(?string $userId): static
    {
        return $this->set(self::LINK_USER. 'Id', $userId);
    }

    public function getParent(): ?LinkParent
    {
        /** @var ?LinkParent */
        return $this->getValueObject(Field::PARENT);
    }

    public function setParent(?LinkParent $parent): static
    {
        return $this->setValueObject(Field::PARENT, $parent);
    }

    public function getStatus(): string
    {
        return $this->get(self::ATTRIBUTE_STATUS);
    }

    public function setStatus(string $status): static
    {
        return $this->set(self::ATTRIBUTE_STATUS, $status);
    }

    public function setFailReason(?string $failReason): static
    {
        return $this->set(self::ATTRIBUTE_FAIL_REASON, $failReason);
    }

    public function getFailReason(): ?string
    {
        return $this->get(self::ATTRIBUTE_FAIL_REASON);
    }

    public function setSentAt(?string $sentAt): static
    {
        return $this->set(self::ATTRIBUTE_SENT_AT, $sentAt);
    }
}
