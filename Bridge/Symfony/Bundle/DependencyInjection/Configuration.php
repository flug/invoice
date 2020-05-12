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

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('flug_invoice');
        $rootNode = $treeBuilder->getRootNode();
        $rootNode->children()
            ->scalarNode('currency')
            ->validate()
            ->ifNotInArray(array_keys($this->loadCurrencies()))
            ->thenInvalid('this currency %s is not supported')
            ->end()
            ->defaultValue('EUR')->end()
            ->scalarNode('footnote')->end()
            ->integerNode('decimal')->defaultValue(2)->end()
            ->booleanNode('with_pagination')->isRequired()->defaultTrue()->end()
            ->booleanNode('duplication_header')->isRequired()->defaultFalse()->end()
            ->booleanNode('display_images')->defaultTrue()->end()
            ->scalarNode('template')->isRequired()->end()
            ->end();
        $this->buildLogo($rootNode);
        $this->buildBusinessDetails($rootNode);
        $this->buildTaxRates($rootNode);
        $this->buildDue($rootNode);

        return $treeBuilder;
    }

    private function buildLogo(ArrayNodeDefinition $rootNode): void
    {
        $rootNode->children()
            ->arrayNode('logo')
            ->children()
            ->scalarNode('file')->end()
            ->integerNode('height')->defaultValue(0)->end()
            ->end()
            ->end();
    }

    private function buildBusinessDetails(ArrayNodeDefinition $rootNode): void
    {
        $rootNode->children()
            ->arrayNode('business_details')
            ->children()
            ->scalarNode('name')->example('My Company')->isRequired()->end()
            ->scalarNode('id')->example('134545f1ca1')->isRequired()->end()
            ->scalarNode('phone')->example('+34 123 456 789')->isRequired()->end()
            ->scalarNode('location')->example('Main Street 1st')->isRequired()->end()
            ->scalarNode('zip')->example('44000')->isRequired()->end()
            ->scalarNode('city')->example('Nantes')->isRequired()->end()
            ->scalarNode('country')->example('France')->isRequired()->end()
            ->end()
            ->end();
    }

    private function buildTaxRates(ArrayNodeDefinition $rootNode): void
    {
        $rootNode->children()
            ->arrayNode('tax_rates')
            ->arrayPrototype()
            ->children()
            ->scalarNode('name')->end()
            ->integerNode('tax')->isRequired()->end()
            ->scalarNode('type')->isRequired()
            ->validate()
            ->ifNotInArray(['percentage', 'fixed'])
            ->thenInvalid('Invalid type of tax %s')
            ->end();
    }

    private function buildDue(ArrayNodeDefinition $rootNode): void
    {
        $rootNode->children()
            ->arrayNode('due')
            ->children()
            ->scalarNode('format')->end()
            ->scalarNode('date')->end()
            ->end()
            ->end();
    }

    private function loadCurrencies(): array
    {
        return json_decode(file_get_contents(__DIR__.'/../Resources/Currencies.json'), true);
    }
}
