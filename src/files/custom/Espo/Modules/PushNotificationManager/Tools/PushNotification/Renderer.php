<?php

namespace Espo\Modules\PushNotificationManager\Tools\PushNotification;

use Espo\Core\Exceptions\NotFound;
use Espo\Core\Htmlizer\TemplateRendererFactory;
use Espo\Core\Record\ServiceContainer;
use Espo\Modules\PushNotificationManager\Entities\PushNotification;
use Espo\Modules\PushNotificationManager\Entities\PushNotificationTemplate;
use Espo\ORM\EntityManager;
use League\HTMLToMarkdown\HtmlConverter;
use RuntimeException;

class Renderer
{
    public function __construct(
        private readonly ServiceContainer $serviceContainer,
        private readonly EntityManager $entityManager,
        private readonly TemplateRendererFactory $templateRendererFactory,
        private readonly HtmlConverter $htmlConverter
    ) {}

    /**
     * @throws NotFound
     */
    public function render(PushNotification $message): string
    {
        $templateId = $message->getPushNotificationTemplateId();
        if (!$templateId) {
            throw new RuntimeException('Push notification template id is not set.');
        }

        $template = $this->entityManager
            ->getRDBRepositoryByClass(PushNotificationTemplate::class)
            ->getById($templateId);

        if (!$template) {
            throw new NotFound("Push notification template $templateId does not exist.");
        }

        $parent = $message->getParent();
        $parentEntity = null;
        if ($parent) {
            $parentEntity = $this->entityManager->getEntityById(
                $parent->getEntityType(),
                $parent->getId()
            );
        }

        $renderer = $this->templateRendererFactory->create()
            ->setTemplate($template->getBody());

        if ($parentEntity) {
            $service = $this->serviceContainer->get($parent->getEntityType());
            $service->loadAdditionalFields($parentEntity);
            $renderer->setEntity($parentEntity);
        }

        $additionalData = json_decode(json_encode($message->getTemplateData()), true);

        if (!empty($additionalData)) {
            $renderer->setData($additionalData);
        }

        $html = $renderer->render();
        return $this->htmlConverter->convert($html);
    }
}
