# Meritoo Common Bundle

Common & useful classes, resources, extensions. Based on Symfony framework.

# Dependency Injection Extension

### Introduction

Configuration parameters are loaded by `Meritoo\CommonBundle\DependencyInjection\Configuration` class that
implements `Symfony\Component\Config\Definition\ConfigurationInterface` and
uses `Symfony\Component\Config\Definition\Builder\TreeBuilder` to build structure of configuration parameters.

If the Dependency Injection extension class extends `Meritoo\CommonBundle\DependencyInjection\Base\BaseExtension` class,
each parameter is automatically loaded into container with name based on nodes from structure of configuration separated
by `.`.

### Example

```php
// A piece of getConfigTreeBuilder() method from Configuration class
$rootNode = $treeBuilder->root('my_main_node');

$rootNode
    ->addDefaultsIfNotSet()
    ->children()
        ->arrayNode('lorem')
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('ipsum')
                    ->defaultValue(1234)
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ->end()
        ->scalarNode('dolor')
            ->defaultValue('')
        ->end()
        ->scalarNode('sit')
        ->end()
    ->end()
;
```

```yaml
# Parameters loaded into container (with values based on defaults)

my_main_node.lorem.ipsum # Value: 1234
my_main_node.dolor       # Value: ""
my_main_node.sit         # Value: null
```

# More

1. [Configuration](Configuration.md)
2. [**Dependency Injection Extension**](Dependency-Injection-Extension.md)
3. [Descriptor of application](Descriptor-of-application.md)
4. [Descriptor of bundle](Descriptor-of-bundle.md)
5. [Descriptors of bundles](Descriptors-of-bundles.md)
6. Services:
    - [ApplicationService](Services/ApplicationService.md)
    - [DateService](Services/DateService.md)
    - [FormService](Services/FormService.md)
    - [ResponseService](Services/ResponseService.md)
7. [Tests](Tests.md)
8. [Translations](Translations.md)
9. Twig extensions:
    - [ApplicationExtension](Twig-Extensions/ApplicationExtension.md)
    - [CommonExtension](Twig-Extensions/CommonExtension.md)
    - [FormExtension](Twig-Extensions/FormExtension.md)

[&lsaquo; Back to `Readme`](../README.md)
