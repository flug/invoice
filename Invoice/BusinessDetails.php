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

class BusinessDetails
{
    private string $name;
    private string $id;
    private string $phone;
    private string $location;
    private string $zip;
    private string $city;
    private string $country;

    public function __construct(
        string $name,
        string $id,
        string $phone,
        string $location,
        string $zip,
        string $city,
        string $country
    ) {
        $this->name = $name;
        $this->id = $id;
        $this->phone = $phone;
        $this->location = $location;
        $this->zip = $zip;
        $this->city = $city;
        $this->country = $country;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
}
