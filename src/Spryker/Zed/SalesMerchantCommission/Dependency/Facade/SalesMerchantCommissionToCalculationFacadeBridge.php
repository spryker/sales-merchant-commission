<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesMerchantCommission\Dependency\Facade;

use Generated\Shared\Transfer\OrderTransfer;

class SalesMerchantCommissionToCalculationFacadeBridge implements SalesMerchantCommissionToCalculationFacadeInterface
{
    /**
     * @var \Spryker\Zed\Calculation\Business\CalculationFacadeInterface
     */
    protected $calculationFacade;

    /**
     * @param \Spryker\Zed\Calculation\Business\CalculationFacadeInterface $calculationFacade
     */
    public function __construct($calculationFacade)
    {
        $this->calculationFacade = $calculationFacade;
    }

    public function recalculateOrder(OrderTransfer $orderTransfer): OrderTransfer
    {
        return $this->calculationFacade->recalculateOrder($orderTransfer);
    }
}
