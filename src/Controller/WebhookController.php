<?php

declare(strict_types=1);

namespace PayonePayment\Controller;

use PayonePayment\Payone\Webhook\Processor\WebhookProcessorInterface;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebhookController extends StorefrontController
{
    /** @var WebhookProcessorInterface */
    private $webhookProcessor;

    public function __construct(WebhookProcessorInterface $webhookProcessor)
    {
        $this->webhookProcessor = $webhookProcessor;
    }

    /**
     * @RouteScope(scopes={"storefront"})
     * @Route("/payone/webhook", name="payone_webhook", defaults={"csrf_protected": false}, methods={"POST"})
     */
    public function execute(Request $request, SalesChannelContext $salesChannelContext): Response
    {
        return $this->webhookProcessor->process($salesChannelContext, $request->request->all());
    }

    /**
     * @RouteScope(scopes={"api"})
     * @Route("/api/_action/payone/requeue-forward", name="api.action.payone.requeue.forward", methods={"POST"})
     * @Route("/api/v{version}/_action/payone/requeue-forward", name="api.action.payone.requeue.forward.legacy", methods={"POST"})
     */
    public function reQueueForward(Request $request, Context $context): Response
    {
        //TODO: get id
        //TODO: get forward by id
        //TODO: repersist forward

        //TODO: success response
        //TODO: error response
    }
}
