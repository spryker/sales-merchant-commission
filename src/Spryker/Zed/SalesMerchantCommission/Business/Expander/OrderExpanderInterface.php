<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesMerchantCommission\Business\Expander;

use Generated\Shared\Transfer\MerchantCommissionCalculationResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;

interface OrderExpanderInterface
{
    public function expandOrderWithMerchantCommissions(
        OrderTransfer $orderTransfer,
        MerchantCommissionCalculationResponseTransfer $merchantCommissionCalculationResponseTransfer
    ): OrderTransfer;
}
