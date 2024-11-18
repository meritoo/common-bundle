<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\DependencyInjection;

use Meritoo\CommonBundle\Enums\Date\DateLength;
use Meritoo\CommonBundle\Service\ApplicationService;
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
        $treeBuilder = new TreeBuilder('meritoo_common');

        $treeBuilder
            ->getRootNode()
            ->children()
                ->append($this->getApplicationNode())
                ->append($this->getDateNode())
                ->append($this->getFormNode())
                ->append($this->getPaginationNode())
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
        $treeBuilder = new TreeBuilder('application');

        return $treeBuilder
            ->getRootNode()
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
    }

    /**
     * Returns the "form" node
     *
     * @return NodeDefinition
     */
    private function getFormNode(): NodeDefinition
    {
        $treeBuilder = new TreeBuilder('form');

        return $treeBuilder
            ->getRootNode()
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('novalidate')
                    ->info('Information if HTML5 inline validation is disabled')
                    ->defaultFalse()
                ->end()
            ->end()
        ;
    }

    /**
     * Returns the "date" node
     *
     * @return NodeDefinition
     */
    private function getDateNode(): NodeDefinition
    {
        $treeBuilder = new TreeBuilder('date');

        return $treeBuilder
            ->getRootNode()
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('format')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode(DateLength::Date->value)
                            ->info('Format of date without time')
                            ->defaultValue('d.m.Y')
                        ->end()
                        ->scalarNode(DateLength::DateTime->value)
                            ->info('Format of date with time')
                            ->defaultValue('d.m.Y H:i')
                        ->end()
                        ->scalarNode(DateLength::Time->value)
                            ->info('Format of time without date')
                            ->defaultValue('H:i')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function getPaginationNode(): NodeDefinition
    {
        $treeBuilder = new TreeBuilder('pagination');

        return $treeBuilder
            ->getRootNode()
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('template_path')
                    ->info('Path of template to render pagination')
                    ->defaultValue('')
                ->end()
                ->scalarNode('per_page')
                    ->info('Number of elements rendered on one page')
                    ->defaultNull()
                ->end()
                ->scalarNode('nearby_current_page_count')
                    ->info('Number of pages nearby current page')
                    ->defaultNull()
                ->end()
            ->end()
        ;
    }
}
