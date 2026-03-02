<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesMerchantCommission\Persistence;

use Generated\Shared\Transfer\SalesMerchantCommissionTransfer;
use Orm\Zed\SalesMerchantCommission\Persistence\SpySalesMerchantCommission;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \Spryker\Zed\SalesMerchantCommission\Persistence\SalesMerchantCommissionPersistenceFactory getFactory()
 */
class SalesMerchantCommissionEntityManager extends AbstractEntityManager implements SalesMerchantCommissionEntityManagerInterface
{
    public function createSalesMerchantCommission(
        SalesMerchantCommissionTransfer $salesMerchantCommissionTransfer
    ): SalesMerchantCommissionTransfer {
        $salesMerchantCommissionMapper = $this->getFactory()->createSalesMerchantCommissionMapper();
        $salesMerchantCommissionEntity = $salesMerchantCommissionMapper->mapSalesMerchantCommissionTransferToSalesMerchantCommissionEntity(
            $salesMerchantCommissionTransfer,
            new SpySalesMerchantCommission(),
        );

        $salesMerchantCommissionEntity->save();

        return $salesMerchantCommissionMapper->mapSalesMerchantCommissionEntityToSalesMerchantCommissionTransfer(
            $salesMerchantCommissionEntity,
            $salesMerchantCommissionTransfer,
        );
    }

    public function updateSalesMerchantCommission(
        SalesMerchantCommissionTransfer $salesMerchantCommissionTransfer
    ): SalesMerchantCommissionTransfer {
        /** @var \Orm\Zed\SalesMerchantCommission\Persistence\SpySalesMerchantCommission $salesMerchantCommissionEntity */
        $salesMerchantCommissionEntity = $this->getFactory()
            ->getSalesMerchantCommissionQuery()
            ->filterByIdSalesMerchantCommission($salesMerchantCommissionTransfer->getIdSalesMerchantCommissionOrFail())
            ->findOne();

        $salesMerchantCommissionEntity = $this->getFactory()
            ->createSalesMerchantCommissionMapper()
            ->mapSalesMerchantCommissionTransferToSalesMerchantCommissionEntity(
                $salesMerchantCommissionTransfer,
                $salesMerchantCommissionEntity,
            );

        $salesMerchantCommissionEntity->save();

        return $salesMerchantCommissionTransfer;
    }
}
