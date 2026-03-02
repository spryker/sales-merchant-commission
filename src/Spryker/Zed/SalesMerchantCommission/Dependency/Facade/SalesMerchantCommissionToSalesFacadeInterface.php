<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesMerchantCommission\Dependency\Facade;

use Generated\Shared\Transfer\OrderTransfer;

interface SalesMerchantCommissionToSalesFacadeInterface
{
    public function findOrderByIdSalesOrder(int $idSalesOrder): ?OrderTransfer;

    public function updateOrder(OrderTransfer $orderTransfer, int $idSalesOrder): bool;
}
