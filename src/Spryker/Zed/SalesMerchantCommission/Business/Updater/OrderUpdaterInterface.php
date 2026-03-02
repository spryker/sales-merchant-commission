<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesMerchantCommission\Business\Updater;

use Generated\Shared\Transfer\MerchantCommissionCalculationResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;

interface OrderUpdaterInterface
{
    public function updateOrderItemsWithTotals(
        OrderTransfer $orderTransfer,
        MerchantCommissionCalculationResponseTransfer $merchantCommissionCalculationResponseTransfer
    ): OrderTransfer;
}
