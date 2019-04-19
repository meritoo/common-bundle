# Meritoo Common Bundle

Common & useful classes, resources, extensions. Based on Symfony framework.

# Descriptor of application

Located here: `Meritoo\CommonBundle\Application\Descriptor`. Contains information about application such as:

1. Name of application
2. Description of application
3. Version of application

### Create instance

Simply use `new` keyword:

```php
$descriptor = new Descriptor(
    'Ultricies',
    'Nullam quis risus eget urna mollis ornare vel eu leo',
    new Version(10, 99, 73)
);
```

You have to pass 3 arguments:

1. string - name of application
2. string - description of application
3. instance of `Meritoo\Common\ValueObject\Version` - version of application

### Methods

Simple 3 getters:

1. getName()
2. getDescription()
3. getVersion()

### String representation of descriptor

Create instance and cast to string:

```php
$descriptor = new Descriptor(
    'Ultricies',
    'Nullam quis risus eget',
    new Version(10, 99, 73)
),

$string = (string)$descriptor;

// Result:
// "Ultricies | Nullam quis risus eget | 10.99.73"
```

# More

1. [Configuration](Configuration.md)
2. [Dependency Injection Extension](Dependency-Injection-Extension.md)
3. [**Descriptor of application**](Descriptor-of-application.md)
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
