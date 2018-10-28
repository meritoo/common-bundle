<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\DependencyInjection;

use Meritoo\CommonBundle\Service\ApplicationService;
use Meritoo\CommonBundle\Type\Date\DateLength;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration of this bundle
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('meritoo_common');

        $rootNode
            ->children()
                ->append($this->getApplicationNode())
                ->append($this->getDateNode())
                ->append($this->getFormNode())
            ->end()
        ;

        return $treeBuilder;
    }

    /**
     * Returns the "application" node
     *
     * @return NodeDefinition
     */
    private function getApplicationNode(): NodeDefinition
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('application');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('version')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('file_path')
                            ->info('Path of a file who contains version of the application')
                            ->defaultValue(sprintf('%%kernel.project_dir%%/%s', ApplicationService::VERSION_FILE_NAME))
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('name')
                    ->info('Name of application. May be displayed near logo.')
                    ->defaultValue('')
                ->end()
                ->scalarNode('description')
                    ->info('Description of application. May be displayed near logo.')
                    ->defaultValue('')
                ->end()
                ->scalarNode('empty_value_replacement')
                    ->info('Replacement of empty value. May be used to filter values in templates/views.')
                    ->defaultValue('-')
                ->end()
            ->end()
        ;

        return $rootNode;
    }

    /**
     * Returns the "form" node
     *
     * @return NodeDefinition
     */
    private function getFormNode(): NodeDefinition
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('form');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('novalidate')
                    ->info('Information if HTML5 inline validation is disabled')
                    ->defaultFalse()
                ->end()
            ->end()
        ;

        return $rootNode;
    }

    /**
     * Returns the "date" node
     *
     * @return NodeDefinition
     */
    private function getDateNode(): NodeDefinition
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('date');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('format')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode(DateLength::DATE)
                            ->info('Format of date without time')
                            ->defaultValue('d.m.Y')
                        ->end()
                        ->scalarNode(DateLength::DATETIME)
                            ->info('Format of date with time')
                            ->defaultValue('d.m.Y H:i')
                        ->end()
                        ->scalarNode(DateLength::TIME)
                            ->info('Format of time without date')
                            ->defaultValue('H:i')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $rootNode;
    }
}
