<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Payment\Dependency\Plugin\Checkout;

use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

/**
 * @deprecated Use \Spryker\Zed\Payment\Dependency\Plugin\Checkout\CheckoutPreConditionPluginInterface instead.
 *
 * Interface for the plugin stack defined as \Spryker\Zed\Payment\PaymentDependencyProvider::CHECKOUT_PRE_CHECK_PLUGINS
 */
interface CheckoutPreCheckPluginInterface extends CheckoutPluginInterface
{
    /**
     * Specification:
     * - Executes a pre-condition for checkout
     * - Notifies about failed condition by filling CheckoutResponse errors
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponse
     *
     * @return void
     */
    public function execute(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponse);
}
