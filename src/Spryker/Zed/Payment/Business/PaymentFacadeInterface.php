<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Payment\Business;

use Generated\Shared\Transfer\CalculableObjectTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\PaymentMethodResponseTransfer;
use Generated\Shared\Transfer\PaymentMethodTransfer;
use Generated\Shared\Transfer\PaymentProviderCollectionTransfer;
use Generated\Shared\Transfer\PaymentProviderResponseTransfer;
use Generated\Shared\Transfer\PaymentProviderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SalesPaymentTransfer;

/**
 * @method \Spryker\Zed\Payment\Business\PaymentBusinessFactory getFactory()
 */
interface PaymentFacadeInterface
{
    /**
     * Specification:
     * - Finds available payment methods
     * - Runs filter plugins
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentMethodsTransfer
     */
    public function getAvailableMethods(QuoteTransfer $quoteTransfer);

    /**
     * Specification:
     * - Distributes total price to payment methods
     * - Calculates price to pay
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CalculableObjectTransfer $calculableObjectTransfer
     *
     * @return void
     */
    public function recalculatePayments(CalculableObjectTransfer $calculableObjectTransfer);

    /**
     * Specification:
     * - Finds payment providers which has available payment methods for the given store.
     *
     * @api
     *
     * @param string $storeName
     *
     * @return \Generated\Shared\Transfer\PaymentProviderCollectionTransfer
     */
    public function getAvailablePaymentProvidersForStore(string $storeName): PaymentProviderCollectionTransfer;

    /**
     * Specification:
     * - Finds payment method by the provided id.
     *
     * @api
     *
     * @param int $idPaymentMethod
     *
     * @return \Generated\Shared\Transfer\PaymentMethodResponseTransfer
     */
    public function findPaymentMethodById(int $idPaymentMethod): PaymentMethodResponseTransfer;

    /**
     * Specification:
     * - Updates payment method in database using provided PaymentMethod transfer object data.
     * - Updates or creates payment method store relations using 'storeRelation' collection in the PaymentMethod transfer object.
     * - Returns PaymentMethodResponse transfer object.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PaymentMethodTransfer $paymentMethodTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentMethodResponseTransfer
     */
    public function updatePaymentMethod(
        PaymentMethodTransfer $paymentMethodTransfer
    ): PaymentMethodResponseTransfer;

    /**
     * Specification:
     * - Checks if selected payment methods exist.
     * - Checks `QuoteTransfer.payments` and `QuoteTransfer.payment` for BC reasons.
     * - Returns `false` and add an error in case at least one of the payment methods
     *  does not exist or is not available for `QuoteTransfer`.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return bool
     */
    public function isQuotePaymentMethodValid(
        QuoteTransfer $quoteTransfer,
        CheckoutResponseTransfer $checkoutResponseTransfer
    ): bool;

    /**
     * Specification:
     * - Creates payment provider.
     * - Requires PaymentProviderTransfer.paymentProviderKey.
     * - Requires PaymentProviderTransfer.name.
     * - Creates payment methods if PaymentProviderTransfer.paymentMethods are provided.
     * - Requires PaymentMethodTransfer.paymentMethodKey.
     * - Requires PaymentMethodTransfer.name.
     * - Creates payment method store relations if PaymentMethodTransfer.storeRelation is provided.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PaymentProviderTransfer $paymentProviderTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentProviderResponseTransfer
     */
    public function createPaymentProvider(PaymentProviderTransfer $paymentProviderTransfer): PaymentProviderResponseTransfer;

    /**
     * Specification:
     * - Creates payment method.
     * - Requires PaymentMethodTransfer.idPaymentProvider.
     * - Requires PaymentMethodTransfer.paymentMethodKey.
     * - Requires PaymentMethodTransfer.name.
     * - Creates payment method store relations if PaymentMethodTransfer.storeRelation is provided.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PaymentMethodTransfer $paymentMethodTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentMethodResponseTransfer
     */
    public function createPaymentMethod(PaymentMethodTransfer $paymentMethodTransfer): PaymentMethodResponseTransfer;

    /**
     * Specification:
     * - Deactivates payment method.
     * - Requires PaymentMethodTransfer.idPaymentMethod.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PaymentMethodTransfer $paymentMethodTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentMethodResponseTransfer
     */
    public function deactivatePaymentMethod(PaymentMethodTransfer $paymentMethodTransfer): PaymentMethodResponseTransfer;

    /**
     * Specification:
     * - Activates payment method.
     * - Requires PaymentMethodTransfer.idPaymentMethod.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PaymentMethodTransfer $paymentMethodTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentMethodResponseTransfer
     */
    public function activatePaymentMethod(PaymentMethodTransfer $paymentMethodTransfer): PaymentMethodResponseTransfer;

    /**
     * Specification:
     * - Runs pre-check plugins
     *
     * @api
     *
     * @deprecated Will be removed without replacement.
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return bool
     */
    public function checkoutPreCheck(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponseTransfer);

    /**
     * Specification:
     * - Runs post-check plugins
     *
     * @api
     *
     * @deprecated Will be removed without replacement.
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return void
     */
    public function checkoutPostCheck(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponseTransfer);

    /**
     * Specification:
     *  - Returns payment method price to pay
     *
     * @api
     *
     * @deprecated Use QuoteTransfer.payments or OrderTransfer.payments instead to get amount per payment method.
     *
     * @param \Generated\Shared\Transfer\SalesPaymentTransfer $salesPaymentTransfer
     *
     * @return int
     */
    public function getPaymentMethodPriceToPay(SalesPaymentTransfer $salesPaymentTransfer);

    /**
     * Specification:
     *  - Populates order transfer with payment data
     *
     * @api
     *
     * @deprecated Use {@link \Spryker\Zed\SalesPayment\Business\SalesPaymentFacadeInterface::expandOrderWithPayments()} instead.
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function hydrateOrderPayments(OrderTransfer $orderTransfer);

    /**
     * Specification:
     * - Creates sales payments
     *
     * @api
     *
     * @deprecated Use {@link \Spryker\Zed\SalesPayment\Business\SalesPaymentFacadeInterface::saveOrderPayments} instead.
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponse
     *
     * @return void
     */
    public function savePaymentForCheckout(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponse);
}
