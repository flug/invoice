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

namespace Flug\Bridge\Symfony\Bundle\Twig;

use Flug\Invoice\ConfigurationInterface;
use Flug\Invoice\TaxRate;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PriceExtension extends AbstractExtension
{
    private array $currencies;

    private ConfigurationInterface $configuration;

    public function __construct(ConfigurationInterface $configuration)
    {
        $this->currencies = json_decode(file_get_contents(__DIR__.'/../Resources/Currencies.json'), true);
        $this->configuration = $configuration;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('symbol', [$this, 'getSymbol']),
            new TwigFunction('total', [$this, 'getTotal']),
            new TwigFunction('subTotal', [$this, 'getSubTotal']),
            new TwigFunction('taxFormatted', [$this, 'taxFormatted']),
            new TwigFunction('totalPriceFormatted', [$this, 'totalPriceFormatted']),
        ];
    }

    public function getSymbol()
    {
        return $this->currencies[$this->configuration->getCurrency()]['symbol'];
    }

    public function getTotal(string $price, string $amount): string
    {
        return number_format((float) bcmul($price, $amount, $this->configuration->getDecimal()),
            $this->configuration->getDecimal());
    }

    public function getSubTotal(array $items)
    {
        return number_format($this->computeSubTotal($items), $this->configuration->getDecimal());
    }

    private function computeSubTotal(array $items)
    {
        $subTotal = array_map(function ($item) {
            return bcmul((string) $item['price'], (string) $item['amount'], $this->configuration->getDecimal());
        }, $items);

        return array_sum($subTotal);
    }

    private function taxPrice(
        array $items,
        ?TaxRate $taxRate = null
    ) {
        if (null === $taxRate) {
            $taxTotal = 0;
            /* @var TaxRate $taxe */
            foreach ($this->configuration->getTaxRates() as $taxRate) {
                if ('percentage' == $taxRate->getType()) {
                    $taxTotal += bcdiv(bcmul((string) $taxRate->getTax(), (string) $this->computeSubTotal($items),
                        $this->configuration->getDecimal()),
                        (string) 100,
                        $this->configuration->getDecimal());
                    continue;
                }
                $taxTotal += $taxRate->getTax();
            }

            return $taxTotal;
        }
        if ('percentage' == $taxRate->getType()) {
            return bcdiv(bcmul((string) $taxRate->getTax(), (string) $this->computeSubTotal($items),
                $this->configuration->getDecimal()),
                (string) 100,
                $this->configuration->getDecimal());
        }

        return $taxRate->getTax();
    }

    private function totalPrice(array $items, ?TaxRate $taxRate = null)
    {
        return bcadd((string) $this->computeSubTotal($items), (string) $this->taxPrice($items, $taxRate),
            $this->configuration->getDecimal());
    }

    /**
     * Return formatted tax.
     *
     * @method taxPriceFormatted
     *
     * @return int
     */
    public function taxFormatted(array $items, ?TaxRate $taxRate = null)
    {
        return number_format((float) $this->taxPrice($items, $taxRate), $this->configuration->getDecimal());
    }

    public function totalPriceFormatted(array $items, ?TaxRate $taxRate = null)
    {
        return number_format((float) $this->totalPrice($items, $taxRate), $this->configuration->getDecimal());
    }
}
