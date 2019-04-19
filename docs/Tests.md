# Meritoo Common Bundle

Common & useful classes, resources, extensions. Based on Symfony framework.

# Tests

### Twig extension

Use `BaseTwigExtensionTestCase` class. It's a base test case for Twig extension.

##### Implementation

Extend this class, implement abstract `getExtensionNamespace()` method and you can easily verify Twig extension.

Example of `getExtensionNamespace()` method implementation:

```php
/**
 * {@inheritdoc}
 */
protected function getExtensionNamespace(): string
{
    return ApplicationExtension::class;
}
```

##### Simple and quick verification of functions, filters etc.

Use `verifyRenderedTemplate()` method to verify template. Pass:

- name of template (anything you want)
- source code of the template
- expected result of rendering the template

Example:

```php
$name = 'anything';
$sourceCode = '{{ meritoo_common_application_descriptor().description }}';
$expected = 'Just for Testing';

$this->verifyRenderedTemplate($name, $sourceCode, $expected);
```

##### Custom verification of functions, filters etc.

In `verifyRenderedTemplate()` method the `assertSame()` *assert* is used. If you want to use another *assert*, render your template and make proper comparison of result with expected result.

Example:
```php
//...

$rendered = $this
    ->getTwigEnvironment($templates)
    ->render($name);

static::assertEquals('lorem ipsum', $rendered);
```

# More

1. [Configuration](Configuration.md)
2. [Dependency Injection Extension](Dependency-Injection-Extension.md)
3. [Descriptor of application](Descriptor-of-application.md)
4. [Descriptor of bundle](Descriptor-of-bundle.md)
5. [Descriptors of bundles](Descriptors-of-bundles.md)
6. Services:
    - [ApplicationService](Services/ApplicationService.md)
    - [DateService](Services/DateService.md)
    - [FormService](Services/FormService.md)
    - [ResponseService](Services/ResponseService.md)
7. [**Tests**](Tests.md)
8. [Translations](Translations.md)
9. Twig extensions:
    - [ApplicationExtension](Twig-Extensions/ApplicationExtension.md)
    - [CommonExtension](Twig-Extensions/CommonExtension.md)
    - [FormExtension](Twig-Extensions/FormExtension.md)

[&lsaquo; Back to `Readme`](../README.md)
