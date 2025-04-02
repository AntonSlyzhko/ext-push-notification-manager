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
    public const ATTRIBUTE_STATUS = 'status';
    public const LINK_PUSH_NOTIFICATION_TEMPLATE = 'pushNotificationTemplate';
    public const LINK_USER = 'user';
    public const STATUS_CREATED = 'Created';
    public const STATUS_SENT = 'Sent';
    public const STATUS_FAILED = 'Failed';

    public function getName(): ?string
    {
        return $this->get(Field::NAME);
    }

    public function setName(?string $name): static
    {
        return $this->set(Field::NAME, $name);
    }

    public function setProvider(string $provider): static
    {
        return $this->set(static::ATTRIBUTE_PROVIDER, $provider);
    }

    public function getPushNotificationTemplateId(): ?string
    {
        return $this->get(static::LINK_PUSH_NOTIFICATION_TEMPLATE. 'Id');
    }

    public function setPushNotificationTemplate(?string $pushNotificationTemplateId): static
    {
        return $this->set(static::LINK_PUSH_NOTIFICATION_TEMPLATE. 'Id', $pushNotificationTemplateId);
    }

    public function getTemplateData(): ?stdClass
    {
        return $this->get(static::ATTRIBUTE_TEMPLATE_DATA);
    }

    /**
     * @param stdClass|array<string, mixed> $data
     */
    public function setTemplateData(stdClass|array $data): static
    {
        return $this->set(static::ATTRIBUTE_TEMPLATE_DATA, $data);
    }

    public function getData(): ?stdClass
    {
        return $this->get(static::ATTRIBUTE_DATA);
    }

    /**
     * @param stdClass|array<string, mixed> $data
     */
    public function setData(stdClass|array $data): static
    {
        return $this->set(static::ATTRIBUTE_DATA, $data);
    }

    public function getUserId(): ?string
    {
        return $this->get(static::LINK_USER. 'Id');
    }

    public function setUserId(?string $userId): static
    {
        return $this->set(static::LINK_USER. 'Id', $userId);
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
        return $this->get(static::ATTRIBUTE_STATUS);
    }

    public function setStatus(string $status): static
    {
        return $this->set(static::ATTRIBUTE_STATUS, $status);
    }
}
