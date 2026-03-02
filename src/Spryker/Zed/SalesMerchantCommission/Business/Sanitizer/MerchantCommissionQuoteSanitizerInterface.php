<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesMerchantCommission\Business\Sanitizer;

use Generated\Shared\Transfer\QuoteTransfer;

interface MerchantCommissionQuoteSanitizerInterface
{
    public function sanitizeMerchantCommissionFromQuote(QuoteTransfer $quoteTransfer): QuoteTransfer;
}
