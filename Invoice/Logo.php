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

class Logo
{
    private string $file;
    private int $height;

    public function __construct(string $file, int $height)
    {
        $this->file = $file;
        $this->height = $height;
    }

    public function getFile(): string
    {
        return $this->file;
    }

    public function getHeight(): int
    {
        return $this->height;
    }
}
