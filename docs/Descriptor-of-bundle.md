# Meritoo Common Bundle

Common & useful classes, resources, extensions. Based on Symfony framework.

# Descriptor of bundle

Located here: `Meritoo\CommonBundle\Bundle\Descriptor`. Contains information about bundle such as:

1. Name of bundle
2. Short, simple name of bundle
3. Name of configuration root node of bundle
4. Root namespace of bundle
5. Physical path of bundle
6. Descriptor of the parent bundle
7. Descriptor of the child bundle
8. Names of files with data fixtures from bundle

### Create instance

There are 3 ways to create new instance:

##### Use `new` keyword

```php
$descriptor = new Descriptor(
    'SimpleBundle',
    'simple_test',
    'Meritoo\Test\CommonBundle\Bundle\Descriptor',
    '/tests/Bundle/Descriptor',
    new Descriptor('ParentBundle', 'parent_test'),
    new Descriptor('ChildBundle', 'child_test')
);
```

##### Use `fromArray()` static method

```php
$descriptor = Descriptor::fromArray([
    'name'                   => 'SimpleBundle',
    'configurationRootName'  => 'simple_test',
    'rootNamespace'          => 'Meritoo\Test\CommonBundle\Bundle\Descriptor',
    'path'                   => '/tests/Bundle/Descriptor',
    'parentBundleDescriptor' => [
        'name'                  => 'ParentBundle',
        'configurationRootName' => 'parent_test',
    ],
    'childBundleDescriptor'  => [
        'name'                  => 'ChildBundle',
        'configurationRootName' => 'child_test',
        'rootNamespace'         => 'Meritoo\Test\CommonBundle\Bundle\Descriptor\Child',
    ],
]);
```

##### Use `fromBundle()` static method

```php
$bundle = new SimpleBundle(),
$descriptor = Descriptor::fromBundle($bundle);
```

### Descriptor of child and parent bundle

Useful when your bundle:
1. Extends another bundle (has parent bundle)
or
2. Is extended by another bundle (has child bundle)

In those situations you can access descriptors of those bundles using methods:

1. `$descriptor->getParentBundleDescriptor()`
2. `$descriptor->getChildBundleDescriptor()`

### Additional/extra methods

##### getShortName()

Returns short, simple name of bundle

Example:

```php
$descriptor = new Descriptor('SimpleBundle');
$shortName = $descriptor->getShortName(); // "simple"
```

##### getDataFixturesDirectoryPath()

Returns real/full path of directory from bundle with classes for the DataFixtures

```php
$descriptor = new Descriptor('', '', '', 'path/of/bundle');
$path = $descriptor->getDataFixturesDirectoryPath(); // "/path/of/bundle/DataFixtures/ORM"
```

##### hasFile()

Returns information if given file belongs to this bundle

```php
$descriptor = new Descriptor('', '', '', 'dapibus/venenatis/quam');
$hasFile = $descriptor->hasFile($filePath); // true
```

##### toArray()

Returns an array representation of the descriptor

```php
$descriptor = new Descriptor(
    'PortaCommodoBundle',
    'Commodo',
    'Porta\CommodoBundle',
    'etiam/risus/parturient'
);

$array = $descriptor->toArray();

/*
 * Result:
 *
 * [
 *     'name'                  => 'PortaCommodoBundle',
 *     'shortName'             => 'portacommodo',
 *     'configurationRootName' => 'Commodo',
 *     'rootNamespace'         => 'Porta\CommodoBundle',
 *     'path'                  => 'etiam/risus/parturient',
 *     'dataFixtures'          => [],
 * ];
 */
```

# More

1. [Configuration](Configuration.md)
2. [Descriptor of application](Descriptor-of-application.md)
3. [**Descriptor of bundle**](Descriptor-of-bundle.md)
4. [Descriptors of bundles](Descriptors-of-bundles.md)
5. Services:
    - [ApplicationService](Services/ApplicationService.md)
    - [DateService](Services/DateService.md)
    - [FormService](Services/FormService.md)
    - [ResponseService](Services/ResponseService.md)
6. [Tests](Tests.md)
7. [Translations](Translations.md)
8. Twig extensions:
    - [ApplicationExtension](Twig-Extensions/ApplicationExtension.md)
    - [CommonExtension](Twig-Extensions/CommonExtension.md)
    - [FormExtension](Twig-Extensions/FormExtension.md)

[&lsaquo; Back to `Readme`](../README.md)
