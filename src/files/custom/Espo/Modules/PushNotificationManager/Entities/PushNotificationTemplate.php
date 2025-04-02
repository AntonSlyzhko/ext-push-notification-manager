<?php

namespace Espo\Modules\PushNotificationManager\Entities;

use Espo\Core\ORM\Entity;
use UnexpectedValueException;

class PushNotificationTemplate extends Entity
{
    public const ENTITY_TYPE = 'PushNotificationTemplate';
    public const ATTRIBUTE_BODY = 'body';
    public const ATTRIBUTE_ENTITY_TYPE = 'entityType';

    public function getTargetEntityType(): string
    {
        $entityType = $this->get(static::ATTRIBUTE_ENTITY_TYPE);

        if ($entityType === null) {
            throw new UnexpectedValueException();
        }

        return $entityType;
    }

    public function getBody(): string
    {
        return $this->get(static::ATTRIBUTE_BODY) ?? "";
    }
}
