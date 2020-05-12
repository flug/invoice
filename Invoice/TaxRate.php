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

class TaxRate
{
    private string $name;
    private int $tax;
    private string $type;

    /**
     * TaxRate constructor.
     */
    public function __construct(string $name, int $tax, string $type)
    {
        $this->name = $name;
        $this->tax = $tax;
        $this->type = $type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTax(): int
    {
        return $this->tax;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
