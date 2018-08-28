# Meritoo Common Bundle

Common & useful classes, resources, extensions. Based on Symfony framework.

# Configuration

### Introduction

Configuration parameters are loaded by `Meritoo\CommonBundle\DependencyInjection\Configuration` class that implements `Symfony\Component\Config\Definition\ConfigurationInterface` and uses `Symfony\Component\Config\Definition\Builder\TreeBuilder` to build structure of configuration parameters.

If the Dependency Injection extension class extends `Meritoo\CommonBundle\DependencyInjection\Base\BaseExtension` class, each parameter is automatically loaded into container with name based on nodes from structure of configuration separated by `.`.

Name of root node: `meritoo_common`.

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

### All parameters of this bundle with default values

```yaml
meritoo_common:
    application:
        version
            file_path: '%kernel.project_dir%/VERSION'
        name: ''
        description: ''
        empty_value_replacement: '-'
    form:
        novalidate: false
```

### Available parameters

* meritoo_common.application.version.file_path

    > Path of a file who contains version of the application.

    Default value: `%kernel.project_dir%/VERSION`.

* meritoo_common.application.name

    > Name of application. May be displayed near logo.
    
    Default value: `""`

* meritoo_common.application.description

    > Description of application. May be displayed near logo.
    
    Default value: `""`

* meritoo_common.application.empty_value_replacement

    > Replacement of empty value. May be used to filter values in templates/views.
    
    Default value: `"-"`

* meritoo_common.form.novalidate

    > Information if HTML5 inline validation is disabled
    
    Default value: `false`

# More

1. [**Configuration**](Configuration.md)
2. [Descriptor of application](Descriptor-of-application.md)
3. [Descriptor of bundle](Descriptor-of-bundle.md)
4. [Descriptors of bundles](Descriptors-of-bundles.md)
5. Services:
	- [ApplicationService](Services/ApplicationService.md)
	- [FormService](Services/FormService.md)
6. [Tests](Tests.md)
7. [Translations](Translations.md)
8. Twig extensions:
	- [ApplicationExtension](Twig-Extensions/ApplicationExtension.md)
	- [CommonExtension](Twig-Extensions/CommonExtension.md)
	- [FormExtension](Twig-Extensions/FormExtension.md)

[&lsaquo; Back to `Readme`](../README.md)
