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

namespace Flug\Bridge\Symfony\Bundle\DependencyInjection;

use Flug\Invoice\BusinessDetails;
use Flug\Invoice\DueDate;
use Flug\Invoice\Generator\Pdf;
use Flug\Invoice\Logo;
use Flug\Invoice\TaxRate;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;

class FlugInvoiceExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $this->buildInvoiceConfiguration($container, $config);
        $this->buildPdfService($container);
    }

    private function buildInvoiceConfiguration(ContainerBuilder $container, array $config): void
    {
        $logoDefinition = new Definition(Logo::class);
        $logoDefinition->setPublic(false)->setPrivate(true);
        $logoDefinition->setArguments([
            $config['logo']['file'],
            $config['logo']['height'],
        ]);
        $businessDetailsDefinition = new Definition(BusinessDetails::class);
        $businessDetailsDefinition->setPublic(false)->setPrivate(true);
        $businessDetailsDefinition->setArguments([
            $config['business_details']['name'],
            $config['business_details']['id'],
            $config['business_details']['phone'],
            $config['business_details']['location'],
            $config['business_details']['zip'],
            $config['business_details']['city'],
            $config['business_details']['country'],
        ]);
        $taxRateDefinitions = [];
        foreach ($config['tax_rates'] as $taxRate) {
            $taxRateDefinition = new Definition(TaxRate::class);
            $taxRateDefinition->setPublic(false)->setPrivate(true);
            $taxRateDefinition->setArguments([
                $taxRate['name'],
                $taxRate['tax'],
                $taxRate['type'],
            ]);
            $taxRateDefinitions[] = $taxRateDefinition;
        }
        $dueDate = new Definition(DueDate::class);
        $dueDate->setPrivate(true)->setPublic(false);
        $dueDate->setArguments([
            $config['due']['format'],
            $config['due']['date'],
        ]);
        $container->setDefinition(\Flug\Invoice\ConfigurationInterface::class,
            new Definition(\Flug\Invoice\Configuration::class))
            ->setArguments([
                $config['currency'],
                $config['decimal'],
                $logoDefinition,
                $businessDetailsDefinition,
                $config['footnote'],
                $taxRateDefinitions,
                $dueDate,
                $config['with_pagination'],
                $config['duplication_header'],
                $config['display_images'],
                $config['template'],
            ]
            )
            ->setAutowired(false)
            ->setPublic(true);
    }

    private function buildPdfService(ContainerBuilder $container): void
    {
        $container->setDefinition(Pdf::class, new Definition(Pdf::class))
            ->setAutowired(true)
            ->setAutoconfigured(true)
            ->setPublic(true);
    }
}
