# Meritoo Common Bundle

Common & useful classes, resources, extensions. Based on Symfony framework.

# FormService

Located here: `Meritoo\CommonBundle\Service\FormService`. Serves forms. Provides method related to forms.

### Parameters from configuration

Uses parameters:

- form.novalidate: `false` (default value)

### Methods

##### addFormOptions()

Adds related to HTML5 inline validation options into the existing options. If HTML5 inline validation is disabled, does nothing.

##### isHtml5ValidationEnabled()

Returns information if HTML5 inline validation is enabled.

# More

1. [Configuration](../Configuration.md)
2. [Descriptor of application](../Descriptor-of-application.md)
3. [Descriptor of bundle](../Descriptor-of-bundle.md)
4. [Descriptors of bundles](../Descriptors-of-bundles.md)
5. Services:
    - [ApplicationService](ApplicationService.md)
    - [DateService](DateService.md)
    - [**FormService**](FormService.md)
    - [ResponseService](ResponseService.md)
6. [Tests](../Tests.md)
7. [Translations](../Translations.md)
8. Twig extensions:
    - [ApplicationExtension](../Twig-Extensions/ApplicationExtension.md)
    - [CommonExtension](../Twig-Extensions/CommonExtension.md)
    - [FormExtension](../Twig-Extensions/FormExtension.md)

[&lsaquo; Back to `Readme`](../../README.md)
