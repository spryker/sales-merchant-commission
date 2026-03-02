<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesMerchantCommission\Persistence;

use Generated\Shared\Transfer\SalesMerchantCommissionTransfer;

interface SalesMerchantCommissionEntityManagerInterface
{
    public function createSalesMerchantCommission(
        SalesMerchantCommissionTransfer $salesMerchantCommissionTransfer
    ): SalesMerchantCommissionTransfer;

    public function updateSalesMerchantCommission(
        SalesMerchantCommissionTransfer $salesMerchantCommissionTransfer
    ): SalesMerchantCommissionTransfer;
}
