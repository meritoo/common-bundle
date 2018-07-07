# Meritoo Common Bundle

Common & useful classes, resources, extensions. Based on Symfony framework.

# Descriptors of bundles

Located here: `Meritoo\CommonBundle\Bundle\Descriptors`. It's a collection who contains descriptors of bundles. Extends `Meritoo\Common\Collection\Collection` class, so all basic methods related collection are available, e.g. `count()`, `isEmpty()`, `add()` etc.

### Create instance

There are 3 ways to create new instance:

##### Use `new` keyword

```php
// An empty collection, without elements
$descriptors = new Descriptors();

$descriptors = new Descriptors([
    new Descriptor('SimpleBundle', 'simple_test'),
    new Descriptor('AnotherBundle', 'another_test'),
]);
```

##### Use `fromArray()` static method

```php
$descriptors = Descriptors::fromArray([
    [
        'name'                  => 'Risus',
        'configurationRootName' => 'Ridiculus',
    ],
    [
        'name'                   => 'Pellentesque',
        'configurationRootName'  => 'Commodo',
        'parentBundleDescriptor' => [
            'name'                  => 'Vulputate',
            'configurationRootName' => 'Dolor',
        ],
    ],
]);
```

### Methods

##### getDescriptor()

Returns descriptor of bundle that contains given class. You have to provide full namespace of any class from bundle who descriptor you are expecting.

Example:

```php
use Vestibulum\Amet\Vehicula\Egestas;

$descriptors = new Descriptors([
    new Descriptor(
        'MattisBundle',
        '',
        'Euismod\Egestas\Mattis'
    ),
    new Descriptor(
        'VehiculaBundle',
        'ipsummattis',
        'Vestibulum\Amet\Vehicula'
    ),
]);

// Look for descriptor of bundle that contains class `Vestibulum\Amet\Vehicula\Egestas`
$descriptor = $descriptors->getDescriptor(Egestas::class);

/*
 * Result:
 *
 * class Meritoo\CommonBundle\Bundle\Descriptor#689 (8) {
 *   private $name =>
 *   string(14) "VehiculaBundle"
 *   private $shortName =>
 *   NULL
 *   private $configurationRootName =>
 *   string(11) "ipsummattis"
 *   private $rootNamespace =>
 *   string(24) "Vestibulum\Amet\Vehicula"
 *   private $path =>
 *   string(0) ""
 *   private $parentBundleDescriptor =>
 *   NULL
 *   private $childBundleDescriptor =>
 *   NULL
 *   private $dataFixtures =>
 *   class Meritoo\Common\Collection\Collection#690 (1) {
 *     private $elements =>
 *     array(0) {
 *     }
 *   }
 * }
 */
```

##### getDescriptorByName()

Returns descriptor of bundle with given name. You have to provide name of bundle who descriptor you are expecting.

Example:

```php
$descriptors = new Descriptors([
    new Descriptor(
        'MattisBundle',
        '',
        'Euismod\Egestas\Mattis'
    ),
    new Descriptor(
        'VehiculaBundle',
        'ipsummattis',
        'Vestibulum\Amet\Vehicula'
    ),
]);

// Look for descriptor of bundle with name `VehiculaBundle`
$descriptor = $descriptors->getDescriptorByName('VehiculaBundle');

/*
 * Result:
 *
 * class Meritoo\CommonBundle\Bundle\Descriptor#689 (8) {
 *   private $name =>
 *   string(14) "VehiculaBundle"
 *   private $shortName =>
 *   NULL
 *   private $configurationRootName =>
 *   string(11) "ipsummattis"
 *   private $rootNamespace =>
 *   string(24) "Vestibulum\Amet\Vehicula"
 *   private $path =>
 *   string(0) ""
 *   private $parentBundleDescriptor =>
 *   NULL
 *   private $childBundleDescriptor =>
 *   NULL
 *   private $dataFixtures =>
 *   class Meritoo\Common\Collection\Collection#690 (1) {
 *     private $elements =>
 *     array(0) {
 *     }
 *   }
 * }
 */
```

##### toArray()

Returns an array representation of the collection. In other words, returns an array with all descriptors that are also represented as arrays.

Example:

```php
$descriptors = new Descriptors([
    new Descriptor('LigulaBundle', '', '', 'ipsum/ridiculus/tellus'),
    new Descriptor('', 'pharetra'),
]);

// Grab all descriptors as an array
$descriptor = $descriptors->toArray();

/*
 * Result:
 *
 * array(2) {
 *   [0] =>
 *   array(6) {
 *     'name' =>
 *     string(12) "LigulaBundle"
 *     'shortName' =>
 *     string(6) "ligula"
 *     'configurationRootName' =>
 *     string(0) ""
 *     'rootNamespace' =>
 *     string(0) ""
 *     'path' =>
 *     string(22) "ipsum/ridiculus/tellus"
 *     'dataFixtures' =>
 *     array(0) {
 *     }
 *   }
 *   [1] =>
 *   array(6) {
 *     'name' =>
 *     string(0) ""
 *     'shortName' =>
 *     string(0) ""
 *     'configurationRootName' =>
 *     string(8) "pharetra"
 *     'rootNamespace' =>
 *     string(0) ""
 *     'path' =>
 *     string(0) ""
 *     'dataFixtures' =>
 *     array(0) {
 *     }
 *   }
 * }
 */
```
# More

1. [Descriptor of application](Descriptor-of-application.md)
2. [Descriptor of bundle](Descriptor-of-bundle.md)
3. [**Descriptors of bundles**](Descriptors-of-bundles.md)
4. Services:
	- [ApplicationService](Services/ApplicationService.md)
5. Twig extensions:
	- [ApplicationExtension](Twig-Extensions/ApplicationExtension.md)

[&lsaquo; Back to `Readme`](../README.md)
