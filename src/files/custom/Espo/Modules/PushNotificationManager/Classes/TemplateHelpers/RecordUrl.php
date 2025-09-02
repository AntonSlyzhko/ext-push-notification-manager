<?php

namespace Espo\Modules\PushNotificationManager\Classes\TemplateHelpers;

use Espo\Core\Htmlizer\Helper;
use Espo\Core\Htmlizer\Helper\Data;
use Espo\Core\Htmlizer\Helper\Result;
use Espo\Core\Utils\Config\ApplicationConfig;

/**
 * @noinspection PhpUnused
 */
class RecordUrl implements Helper
{
    private string $siteUrl;

    public function __construct(
        ApplicationConfig $applicationConfig
    ) {
        $this->siteUrl = $applicationConfig->getSiteUrl();
    }

    public function render(Data $data): Result
    {
        $entityType = $data->getArgumentList()[0];
        $entityId = $data->getArgumentList()[1];
        $text = $data->getArgumentList()[2];

        if (!empty($entityType) && !empty($entityId) && !empty($text)) {
            return Result::createSafeString(
                "<a href=\"$this->siteUrl/#$entityType/view/$entityId\">$text</a>"
            );
        }

        if (!empty($entityType) && empty($entityId)) {
            $text2 = $text ?? $entityType;
            return Result::createSafeString(
                "<a href=\"$this->siteUrl/#$entityType\">$text2</a>"
            );
        }

        return Result::createEmpty();
    }
}
