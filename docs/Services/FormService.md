# Meritoo Common Bundle

Common & useful classes, resources, extensions. Based on Symfony framework.

# FormService

Located here: `Meritoo\CommonBundle\Service\FormService`. Serves forms. Provides method related to forms.

### Parameters from configuration

Uses parameters:

- form.novalidate: `false` (default value)

### Methods

##### addHtml5ValidationOptions()

Adds related to HTML5 inline validation options into the existing options. If HTML5 inline validation is disabled, does
nothing.

##### isHtml5ValidationEnabled()

Returns information if HTML5 inline validation is enabled.

# More

1. [Configuration](../Configuration.md)
2. [Dependency Injection Extension](../Dependency-Injection-Extension.md)
3. [Descriptor of application](../Descriptor-of-application.md)
4. [Descriptor of bundle](../Descriptor-of-bundle.md)
5. [Descriptors of bundles](../Descriptors-of-bundles.md)
6. Services:
    - [ApplicationService](ApplicationService.md)
    - [DateService](DateService.md)
    - [**FormService**](FormService.md)
    - [ResponseService](ResponseService.md)
7. [Tests](../Tests.md)
8. [Translations](../Translations.md)
9. Twig extensions:
    - [ApplicationExtension](../Twig-Extensions/ApplicationExtension.md)
    - [CommonExtension](../Twig-Extensions/CommonExtension.md)
    - [FormExtension](../Twig-Extensions/FormExtension.md)

[&lsaquo; Back to `Readme`](../../README.md)
