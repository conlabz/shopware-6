<?php

declare(strict_types=1);

namespace PayonePayment\Payone\RequestParameter\Builder\SecureInvoice;

use PayonePayment\PaymentHandler\PayoneSecureInvoicePaymentHandler;
use PayonePayment\Payone\RequestParameter\Struct\AbstractRequestParameterStruct;
use PayonePayment\Payone\RequestParameter\Struct\PaymentTransactionStruct;

class PreAuthorizeRequestParameterBuilder extends AuthorizeRequestParameterBuilder
{
    /**
     * @param PaymentTransactionStruct $arguments
     */
    public function getRequestParameter(AbstractRequestParameterStruct $arguments): array
    {
        return array_merge(parent::getRequestParameter($arguments), [
            'request' => self::REQUEST_ACTION_PREAUTHORIZE,
        ]);
    }

    public function supports(AbstractRequestParameterStruct $arguments): bool
    {
        if (!($arguments instanceof PaymentTransactionStruct)) {
            return false;
        }

        $paymentMethod = $arguments->getPaymentMethod();
        $action = $arguments->getAction();

        return $paymentMethod === PayoneSecureInvoicePaymentHandler::class && $action === self::REQUEST_ACTION_PREAUTHORIZE;
    }
}
