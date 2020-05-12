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

final class Invoice implements InvoiceInterface
{
    private array $data;

    public function __construct()
    {
        $this->data['invoice'] = [];
    }

    public function setName(string $name): void
    {
        $this->data['invoice']['name'] = $name;
    }

    public function setNumber(string $number): void
    {
        $this->data['invoice']['number'] = $number;
    }

    public function setCustomerDetails(
        string $name,
        string $id,
        string $phone,
        string $zip,
        string $city,
        string $country,
        string $location
    ): void {
        $this->data['invoice']['customerDetails'] = [
            'name' => $name,
            'id' => $id,
            'phone' => $phone,
            'zip' => $zip,
            'city' => $city,
            'country' => $country,
            'location' => $location,
        ];
    }

    public function addItem(string $name, $price, $amount, $id, ?string $image = null): self
    {
        $this->data['invoice']['items'][] = [
            'name' => $name,
            'price' => $price,
            'amount' => $amount,
            'id' => $id,
            'image' => $image,
        ];

        return $this;
    }

    public function setDate(\DateTimeInterface $date): void
    {
        $this->data['invoice']['date'] = $date;
    }

    public function setNotes(string $notes): void
    {
        $this->data['invoice']['notes'] = $notes;
    }

    public function getInvoice(): array
    {
        return $this->data;
    }
}
