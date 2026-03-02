<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesMerchantCommission\Business\Calculator;

use Generated\Shared\Transfer\CalculableObjectTransfer;

interface MerchantCommissionCalculatorInterface
{
    public function recalculateMerchantCommissions(
        CalculableObjectTransfer $calculableObjectTransfer
    ): CalculableObjectTransfer;
}
