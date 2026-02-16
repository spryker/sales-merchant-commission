<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesMerchantCommission\Business\Updater;

use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;
use Spryker\Zed\SalesMerchantCommission\Persistence\SalesMerchantCommissionEntityManagerInterface;

class SalesMerchantCommissionUpdater implements SalesMerchantCommissionUpdaterInterface
{
    use TransactionTrait;

    /**
     * @var \Spryker\Zed\SalesMerchantCommission\Persistence\SalesMerchantCommissionEntityManagerInterface
     */
    protected SalesMerchantCommissionEntityManagerInterface $salesMerchantCommissionEntityManager;

    /**
     * @param \Spryker\Zed\SalesMerchantCommission\Persistence\SalesMerchantCommissionEntityManagerInterface $salesMerchantCommissionEntityManager
     */
    public function __construct(
        SalesMerchantCommissionEntityManagerInterface $salesMerchantCommissionEntityManager
    ) {
        $this->salesMerchantCommissionEntityManager = $salesMerchantCommissionEntityManager;
    }

    /**
     * @param array<\Generated\Shared\Transfer\SalesMerchantCommissionTransfer> $salesMerchantCommissionTransfers
     *
     * @return array<\Generated\Shared\Transfer\SalesMerchantCommissionTransfer>
     */
    public function updateSalesMerchantCommissions(array $salesMerchantCommissionTransfers): array
    {
        return $this->getTransactionHandler()->handleTransaction(function () use ($salesMerchantCommissionTransfers) {
            return $this->executeUpdateSalesMerchantCommissionsTransaction($salesMerchantCommissionTransfers);
        });
    }

    /**
     * @param array<\Generated\Shared\Transfer\SalesMerchantCommissionTransfer> $salesMerchantCommissionTransfers
     *
     * @return array<\Generated\Shared\Transfer\SalesMerchantCommissionTransfer>
     */
    protected function executeUpdateSalesMerchantCommissionsTransaction(array $salesMerchantCommissionTransfers): array
    {
        $updatedSalesMerchantCommissions = [];
        foreach ($salesMerchantCommissionTransfers as $salesMerchantCommissionTransfer) {
            $updatedSalesMerchantCommissions[] = $this->salesMerchantCommissionEntityManager
                ->updateSalesMerchantCommission($salesMerchantCommissionTransfer);
        }

        return $updatedSalesMerchantCommissions;
    }
}
