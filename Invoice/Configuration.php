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

final class Configuration implements ConfigurationInterface
{
    private string $currency;
    private int $decimal;
    private Logo $logo;
    private BusinessDetails $businessDetails;
    private string $footnote;
    private array $taxRates;
    private DueDate $dueDate;
    private bool $withPagination;
    private bool $duplicationHeader;
    private bool $displayImages;
    private string $template;

    public function __construct(
        string $currency,
        int $decimal,
        Logo $logo,
        BusinessDetails $businessDetails,
        string $footnote,
        array $taxRates,
        DueDate $dueDate,
        bool $withPagination,
        bool $duplicationHeader,
        bool $displayImages,
        string $template
    ) {
        $this->currency = $currency;
        $this->decimal = $decimal;
        $this->logo = $logo;
        $this->businessDetails = $businessDetails;
        $this->footnote = $footnote;
        $this->taxRates = $taxRates;
        $this->dueDate = $dueDate;
        $this->withPagination = $withPagination;
        $this->duplicationHeader = $duplicationHeader;
        $this->displayImages = $displayImages;
        $this->template = $template;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getDecimal(): int
    {
        return $this->decimal;
    }

    public function getLogo(): Logo
    {
        return $this->logo;
    }

    public function getBusinessDetails(): BusinessDetails
    {
        return $this->businessDetails;
    }

    public function getFootnote(): string
    {
        return $this->footnote;
    }

    public function getTaxRates(): array
    {
        return $this->taxRates;
    }

    public function getDueDate(): DueDate
    {
        return $this->dueDate;
    }

    public function isPaginate(): bool
    {
        return $this->withPagination;
    }

    public function hasDuplicationHeader(): bool
    {
        return $this->duplicationHeader;
    }

    public function shouldDisplayImage(): bool
    {
        return $this->displayImages;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }
}
