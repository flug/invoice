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

namespace Flug\Invoice\Generator;

interface InvoiceInterface
{
    public function setName(string $name);

    public function setNumber(string $number);

    public function setCustomerDetails(
        string $name,
        string $id,
        string $phone,
        string $zip,
        string $city,
        string $country,
        string $location
    );

    public function addItem(string $name, string $price, string $amount, string $id, ?string $image = null): self;

    public function setNotes(string $notes);

    public function getInvoice(): array;
}
