<?php

/*
 * This file is part of FlugInvoice project.
 *
 * (c) Flug <flug@clooder.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Flug\Invoice;

interface ConfigurationInterface
{
    public function getCurrency(): string;

    public function getDecimal(): int;

    public function getLogo(): Logo;

    public function getBusinessDetails(): BusinessDetails;

    public function getFootNote(): string;

    /**
     * @return TaxRate[]
     */
    public function getTaxRates(): array;

    public function getDueDate(): DueDate;

    public function isPaginate(): bool;

    public function hasDuplicationHeader(): bool;

    public function getTemplate(): string;
}
