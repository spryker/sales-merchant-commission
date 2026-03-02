<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesMerchantCommission\Business\Expander;

use ArrayObject;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\MerchantCommissionCalculationItemTransfer;
use Generated\Shared\Transfer\MerchantCommissionCalculationResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\TotalsTransfer;

class OrderExpander implements OrderExpanderInterface
{
    public function expandOrderWithMerchantCommissions(
        OrderTransfer $orderTransfer,
        MerchantCommissionCalculationResponseTransfer $merchantCommissionCalculationResponseTransfer
    ): OrderTransfer {
        $expandedItemTransfers = $this->expandOrderItemsWithMerchantCommissions(
            $orderTransfer,
            $merchantCommissionCalculationResponseTransfer,
        );

        $expandedTotalsTransfer = $this->expandOrderTotalsWithMerchantCommissions(
            $orderTransfer->getTotalsOrFail(),
            $merchantCommissionCalculationResponseTransfer,
        );

        return $orderTransfer
            ->setItems((new ArrayObject($expandedItemTransfers)))
            ->setTotals($expandedTotalsTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Generated\Shared\Transfer\MerchantCommissionCalculationResponseTransfer $merchantCommissionCalculationResponseTransfer
     *
     * @return list<\Generated\Shared\Transfer\ItemTransfer>
     */
    protected function expandOrderItemsWithMerchantCommissions(
        OrderTransfer $orderTransfer,
        MerchantCommissionCalculationResponseTransfer $merchantCommissionCalculationResponseTransfer
    ): array {
        $expandedItemTransfers = [];
        $indexedMerchantCommissionCalculationItemTransfers = $this
            ->getMerchantCommissionCalculationItemTransferIndexedByIdSalesOrderItem(
                $merchantCommissionCalculationResponseTransfer,
            );

        foreach ($orderTransfer->getItems() as $itemTransfer) {
            $idSalesOrderItem = $itemTransfer->getIdSalesOrderItemOrFail();
            $merchantCommissionCalculationItemTransfer = $indexedMerchantCommissionCalculationItemTransfers[$idSalesOrderItem] ?? null;

            if ($merchantCommissionCalculationItemTransfer) {
                $itemTransfer = $this->expandOrderItemWithMerchantCommissions(
                    $itemTransfer,
                    $merchantCommissionCalculationItemTransfer,
                );
            }

            $expandedItemTransfers[] = $itemTransfer;
        }

        return $expandedItemTransfers;
    }

    protected function expandOrderItemWithMerchantCommissions(
        ItemTransfer $itemTransfer,
        MerchantCommissionCalculationItemTransfer $merchantCommissionCalculationItemTransfer
    ): ItemTransfer {
        return $itemTransfer
            ->setMerchantCommissionAmountAggregation($merchantCommissionCalculationItemTransfer->getMerchantCommissionAmountAggregationOrFail())
            ->setMerchantCommissionAmountFullAggregation($merchantCommissionCalculationItemTransfer->getMerchantCommissionAmountFullAggregationOrFail());
    }

    protected function expandOrderTotalsWithMerchantCommissions(
        TotalsTransfer $totalsTransfer,
        MerchantCommissionCalculationResponseTransfer $merchantCommissionCalculationResponseTransfer
    ): TotalsTransfer {
        return $totalsTransfer->setMerchantCommissionTotal(
            $merchantCommissionCalculationResponseTransfer->getTotalsOrFail()->getMerchantCommissionTotalOrFail(),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantCommissionCalculationResponseTransfer $merchantCommissionCalculationResponseTransfer
     *
     * @return array<\Generated\Shared\Transfer\MerchantCommissionCalculationItemTransfer>
     */
    protected function getMerchantCommissionCalculationItemTransferIndexedByIdSalesOrderItem(
        MerchantCommissionCalculationResponseTransfer $merchantCommissionCalculationResponseTransfer
    ): array {
        $merchantCommissionCalculationItemTransfers = [];
        foreach ($merchantCommissionCalculationResponseTransfer->getItems() as $merchantCommissionCalculationItemTransfer) {
            $idSalesOrderItem = $merchantCommissionCalculationItemTransfer->getIdSalesOrderItemOrFail();
            $merchantCommissionCalculationItemTransfers[$idSalesOrderItem] = $merchantCommissionCalculationItemTransfer;
        }

        return $merchantCommissionCalculationItemTransfers;
    }
}
