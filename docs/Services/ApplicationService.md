# Meritoo Common Bundle

Common & useful classes, resources, extensions. Based on Symfony framework.

# ApplicationService

Located here: `Meritoo\CommonBundle\Service\ApplicationService`. Serves application. Provides methods related to whole application.

### Parameters from configuration

Uses parameters:

- application.version.file_path: `%kernel.project_dir%/VERSION` (default value)
- application.name: `''` (default value)
- application.description: `''` (default value)

### Methods

##### getDescriptor()

Returns descriptor of application, instance of `Meritoo\CommonBundle\Application\Descriptor` class. Descriptor delivers information about application such as:

1. Name of application
2. Description of application
3. Version of application

# More

1. [Configuration](../Configuration.md)
2. [Descriptor of application](../Descriptor-of-application.md)
3. [Descriptor of bundle](../Descriptor-of-bundle.md)
4. [Descriptors of bundles](../Descriptors-of-bundles.md)
5. Services:
	- [**ApplicationService**](ApplicationService.md)
	- [DateService](DateService.md)
	- [FormService](FormService.md)
	- [ResponseService](ResponseService.md)
6. [Tests](../Tests.md)
7. [Translations](../Translations.md)
8. Twig extensions:
	- [ApplicationExtension](../Twig-Extensions/ApplicationExtension.md)
	- [CommonExtension](../Twig-Extensions/CommonExtension.md)
	- [FormExtension](../Twig-Extensions/FormExtension.md)

[&lsaquo; Back to `Readme`](../../README.md)
