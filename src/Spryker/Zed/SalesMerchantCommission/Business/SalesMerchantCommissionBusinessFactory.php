<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesMerchantCommission\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\SalesMerchantCommission\Business\Calculator\MerchantCommissionCalculator;
use Spryker\Zed\SalesMerchantCommission\Business\Calculator\MerchantCommissionCalculatorInterface;
use Spryker\Zed\SalesMerchantCommission\Business\Collector\MerchantCommissionCollector;
use Spryker\Zed\SalesMerchantCommission\Business\Collector\MerchantCommissionCollectorInterface;
use Spryker\Zed\SalesMerchantCommission\Business\Creator\SalesMerchantCommissionCreator;
use Spryker\Zed\SalesMerchantCommission\Business\Creator\SalesMerchantCommissionCreatorInterface;
use Spryker\Zed\SalesMerchantCommission\Business\Expander\OrderExpander;
use Spryker\Zed\SalesMerchantCommission\Business\Expander\OrderExpanderInterface;
use Spryker\Zed\SalesMerchantCommission\Business\Mapper\MerchantCommissionMapper;
use Spryker\Zed\SalesMerchantCommission\Business\Mapper\MerchantCommissionMapperInterface;
use Spryker\Zed\SalesMerchantCommission\Business\Reader\SalesMerchantCommissionReader;
use Spryker\Zed\SalesMerchantCommission\Business\Reader\SalesMerchantCommissionReaderInterface;
use Spryker\Zed\SalesMerchantCommission\Business\Refunder\MerchantCommissionRefunder;
use Spryker\Zed\SalesMerchantCommission\Business\Refunder\MerchantCommissionRefunderInterface;
use Spryker\Zed\SalesMerchantCommission\Business\Sanitizer\MerchantCommissionQuoteSanitizer;
use Spryker\Zed\SalesMerchantCommission\Business\Sanitizer\MerchantCommissionQuoteSanitizerInterface;
use Spryker\Zed\SalesMerchantCommission\Business\Updater\OrderUpdater;
use Spryker\Zed\SalesMerchantCommission\Business\Updater\OrderUpdaterInterface;
use Spryker\Zed\SalesMerchantCommission\Business\Updater\SalesMerchantCommissionUpdater;
use Spryker\Zed\SalesMerchantCommission\Business\Updater\SalesMerchantCommissionUpdaterInterface;
use Spryker\Zed\SalesMerchantCommission\Dependency\Facade\SalesMerchantCommissionToCalculationFacadeInterface;
use Spryker\Zed\SalesMerchantCommission\Dependency\Facade\SalesMerchantCommissionToMerchantCommissionFacadeInterface;
use Spryker\Zed\SalesMerchantCommission\Dependency\Facade\SalesMerchantCommissionToSalesFacadeInterface;
use Spryker\Zed\SalesMerchantCommission\SalesMerchantCommissionDependencyProvider;

/**
 * @method \Spryker\Zed\SalesMerchantCommission\SalesMerchantCommissionConfig getConfig()
 * @method \Spryker\Zed\SalesMerchantCommission\Persistence\SalesMerchantCommissionEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\SalesMerchantCommission\Persistence\SalesMerchantCommissionRepositoryInterface getRepository()
 */
class SalesMerchantCommissionBusinessFactory extends AbstractBusinessFactory
{
    public function createSalesMerchantCommissionCreator(): SalesMerchantCommissionCreatorInterface
    {
        return new SalesMerchantCommissionCreator(
            $this->getEntityManager(),
            $this->getMerchantCommissionFacade(),
            $this->getSalesFacade(),
            $this->createOrderUpdater(),
            $this->createMerchantCommissionMapper(),
        );
    }

    public function createMerchantCommissionMapper(): MerchantCommissionMapperInterface
    {
        return new MerchantCommissionMapper();
    }

    public function createOrderUpdater(): OrderUpdaterInterface
    {
        return new OrderUpdater(
            $this->getSalesFacade(),
            $this->createOrderExpander(),
        );
    }

    public function createOrderExpander(): OrderExpanderInterface
    {
        return new OrderExpander();
    }

    public function createMerchantCommissionCalculator(): MerchantCommissionCalculatorInterface
    {
        return new MerchantCommissionCalculator(
            $this->createMerchantCommissionCollector(),
            $this->createSalesMerchantCommissionReader(),
        );
    }

    public function createMerchantCommissionRefunder(): MerchantCommissionRefunderInterface
    {
        return new MerchantCommissionRefunder(
            $this->createSalesMerchantCommissionReader(),
            $this->createSalesMerchantCommissionUpdater(),
            $this->getCalculationFacade(),
            $this->getSalesFacade(),
            $this->getPostRefundMerchantCommissionPlugins(),
        );
    }

    public function createSalesMerchantCommissionUpdater(): SalesMerchantCommissionUpdaterInterface
    {
        return new SalesMerchantCommissionUpdater(
            $this->getEntityManager(),
        );
    }

    public function createSalesMerchantCommissionReader(): SalesMerchantCommissionReaderInterface
    {
        return new SalesMerchantCommissionReader(
            $this->getRepository(),
        );
    }

    public function createMerchantCommissionQuoteSanitizer(): MerchantCommissionQuoteSanitizerInterface
    {
        return new MerchantCommissionQuoteSanitizer();
    }

    public function createMerchantCommissionCollector(): MerchantCommissionCollectorInterface
    {
        return new MerchantCommissionCollector();
    }

    public function getMerchantCommissionFacade(): SalesMerchantCommissionToMerchantCommissionFacadeInterface
    {
        return $this->getProvidedDependency(SalesMerchantCommissionDependencyProvider::FACADE_MERCHANT_COMMISSION);
    }

    public function getSalesFacade(): SalesMerchantCommissionToSalesFacadeInterface
    {
        return $this->getProvidedDependency(SalesMerchantCommissionDependencyProvider::FACADE_SALES);
    }

    public function getCalculationFacade(): SalesMerchantCommissionToCalculationFacadeInterface
    {
        return $this->getProvidedDependency(SalesMerchantCommissionDependencyProvider::FACADE_CALCULATION);
    }

    /**
     * @return list<\Spryker\Zed\SalesMerchantCommissionExtension\Dependency\Plugin\PostRefundMerchantCommissionPluginInterface>
     */
    public function getPostRefundMerchantCommissionPlugins(): array
    {
        return $this->getProvidedDependency(SalesMerchantCommissionDependencyProvider::PLUGINS_POST_REFUND_MERCHANT_COMMISSION);
    }
}
