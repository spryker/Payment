<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Payment\Business;

use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SalesPaymentTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Spryker\Zed\Payment\Business\PaymentBusinessFactory getFactory()
 */
class PaymentFacade extends AbstractFacade implements PaymentFacadeInterface
{

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponse
     *
     * @return void
     */
    public function savePaymentForCheckout(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponse)
    {
        $this->getFactory()
            ->createCheckoutPaymentPluginExecutor()
            ->executeOrderSaverPlugin($quoteTransfer, $checkoutResponse);
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return void
     */
    public function checkoutPreCheck(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponseTransfer)
    {
        $this->getFactory()
            ->createCheckoutPaymentPluginExecutor()
            ->executePreCheckPlugin($quoteTransfer, $checkoutResponseTransfer);
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return void
     */
    public function checkoutPostCheck(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponseTransfer)
    {
        $this->getFactory()
            ->createCheckoutPaymentPluginExecutor()
            ->executePostCheckPlugin($quoteTransfer, $checkoutResponseTransfer);
    }

    /**
     *
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\SalesPaymentTransfer $salesPaymentTransfer
     *
     * @return int
     */
    public function getPaymentMethodPriceToPay(SalesPaymentTransfer $salesPaymentTransfer)
    {
        return $this->getFactory()
            ->createSalesPaymentReader()
            ->getPaymentMethodPriceToPay($salesPaymentTransfer);
    }

    /**
     *
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function hydrateOrderPayments(OrderTransfer $orderTransfer)
    {
        return $this->getFactory()
            ->createPaymentHydrator()
            ->hydrateOrderWithPayment($orderTransfer);
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentMethodsTransfer
     */
    public function getAvailableMethods(QuoteTransfer $quoteTransfer)
    {
        return $this->getFactory()->createPaymentMethodMarshaller()->getAvailableMethods($quoteTransfer);
    }

}
