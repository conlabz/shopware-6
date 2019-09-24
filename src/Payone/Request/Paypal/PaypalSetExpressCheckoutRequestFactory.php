<?php

declare(strict_types=1);

namespace PayonePayment\Payone\Request\Paypal;

use PayonePayment\Configuration\ConfigurationPrefixes;
use PayonePayment\Payone\Request\AbstractRequestFactory;
use PayonePayment\Payone\Request\Customer\CustomerRequest;
use PayonePayment\Payone\Request\System\SystemRequest;
use Shopware\Core\Checkout\Cart\Cart;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

class PaypalSetExpressCheckoutRequestFactory extends AbstractRequestFactory
{
    /** @var PaypalSetExpressCheckoutRequest */
    private $expressCheckoutRequest;

    /** @var CustomerRequest */
    private $customerRequest;

    /** @var SystemRequest */
    private $systemRequest;

    public function __construct(
        PaypalSetExpressCheckoutRequest $expressCheckoutRequest,
        CustomerRequest $customerRequest,
        SystemRequest $systemRequest
    ) {
        $this->expressCheckoutRequest = $expressCheckoutRequest;
        $this->customerRequest        = $customerRequest;
        $this->systemRequest          = $systemRequest;
    }

    public function getRequestParameters(
        Cart $cart,
        SalesChannelContext $context,
        string $returnUrl
    ): array {
        $this->requests[] = $this->systemRequest->getRequestParameters(
            $context->getSalesChannel()->getId(),
            ConfigurationPrefixes::CONFIGURATION_PREFIX_PAYPAL,
            $context->getContext()
        );

        $this->requests[] = $this->customerRequest->getRequestParameters(
            $context
        );

        $this->requests[] = $this->expressCheckoutRequest->getRequestParameters(
            $cart,
            $context->getContext(),
            $returnUrl
        );

        return $this->createRequest();
    }
}
